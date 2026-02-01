<?php

namespace Tests\Feature;

use App\Enum\Gender;
use App\Enum\JabatanGuru;
use App\Enum\LevelLMD;
use App\Enum\LevelPelatihanGuru;
use App\Enum\PekerjaanWali;
use App\Enum\RoleType;
use App\Models\City;
use App\Models\District;
use App\Models\EducationLevel;
use App\Models\Person;
use App\Models\Province;
use App\Models\Teacher;
use App\Models\Unit;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeacherManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $adminTpa;
    protected Unit $unit;
    protected User $otherAdminTpa;
    protected Unit $otherUnit;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup storage untuk testing
        Storage::fake('public');

        // Create Admin TPA user dengan unit
        $person = Person::factory()->create();
        $this->adminTpa = User::factory()->create([
            'person_id' => $person->id,
            'email' => 'admin@tpa.test',
            'password' => bcrypt('password'),
        ]);
        $this->adminTpa->roles()->create(['role' => RoleType::ADMIN_TPA->value]);

        // Create unit untuk admin
        $this->unit = Unit::factory()->create([
            'admin_user_id' => $this->adminTpa->id,
        ]);

        // Create another admin TPA dengan unit berbeda (untuk test authorization)
        $otherPerson = Person::factory()->create();
        $this->otherAdminTpa = User::factory()->create([
            'person_id' => $otherPerson->id,
            'email' => 'other@tpa.test',
        ]);
        $this->otherAdminTpa->roles()->create(['role' => RoleType::ADMIN_TPA->value]);
        $this->otherUnit = Unit::factory()->create([
            'admin_user_id' => $this->otherAdminTpa->id,
        ]);
    }

    /** @test */
    public function admin_tpa_can_view_teacher_list()
    {
        $this->actingAs($this->adminTpa);

        // Create some teachers
        Teacher::factory()->count(3)->create([
            'unit_id' => $this->unit->id,
        ]);

        $response = $this->get(route('tpa.teachers.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.teachers.index');
        $response->assertViewHas('teachers');
        $response->assertViewHas('unit');
        $response->assertSee('Daftar Guru');
    }

    /** @test */
    public function admin_tpa_can_view_create_teacher_form()
    {
        $this->actingAs($this->adminTpa);

        $response = $this->get(route('tpa.teachers.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.teachers.create');
        $response->assertViewHas('unit');
        $response->assertViewHas('genders');
        $response->assertViewHas('jabatanOptions');
        $response->assertViewHas('pekerjaanOptions');
        $response->assertSee('Tambah Data Guru');
    }

    /** @test */
    public function admin_tpa_can_create_teacher_with_valid_data()
    {
        $this->actingAs($this->adminTpa);

        $educationLevel = EducationLevel::factory()->create();
        $province = Province::create(['name' => 'Sulawesi Selatan']);

        $teacherData = [
            'nik' => '3273010101900001',
            'full_name' => 'Ahmad Fauzi',
            'birth_place' => 'Bandung',
            'birth_date' => '1990-01-01',
            'gender' => Gender::LAKI_LAKI->value,
            'phone' => '081234567890',
            'education_level_id' => $educationLevel->id,
            'pekerjaan' => PekerjaanWali::WIRASWASTA->value,
            'province_id' => $province->id,
            'jalan' => 'Jl. Merdeka No. 123',
            'rt' => '001',
            'rw' => '005',
            'jabatan_utama' => JabatanGuru::GURU_IQRA->value,
            'tugas_tambahan' => ['admin_operator'],
            'level_lmd' => LevelLMD::LMD_2->value,
            'level_pelatihan_guru' => LevelPelatihanGuru::LEVEL_B->value,
        ];

        $response = $this->post(route('tpa.teachers.store'), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('teachers', [
            'unit_id' => $this->unit->id,
            'nik' => '3273010101900001',
            'full_name' => 'Ahmad Fauzi',
            'jabatan_utama' => JabatanGuru::GURU_IQRA->value,
        ]);

        $teacher = Teacher::where('nik', '3273010101900001')->first();
        $this->assertNotNull($teacher);
        $this->assertEquals([PekerjaanWali::WIRASWASTA->value], $teacher->pekerjaan);
        $this->assertEquals(['admin_operator'], $teacher->tugas_tambahan);
    }

    /** @test */
    public function admin_tpa_can_create_teacher_with_photo_and_certificates()
    {
        $this->actingAs($this->adminTpa);

        $educationLevel = EducationLevel::factory()->create();

        $photo = UploadedFile::fake()->image('teacher.jpg', 800, 600)->size(500);
        $certLmd = UploadedFile::fake()->create('lmd_cert.pdf', 500, 'application/pdf');
        $certTeaching = UploadedFile::fake()->create('teaching_cert.pdf', 500, 'application/pdf');

        $teacherData = [
            'nik' => '3273010101900002',
            'full_name' => 'Siti Aisyah',
            'birth_place' => 'Jakarta',
            'birth_date' => '1992-05-15',
            'gender' => Gender::PEREMPUAN->value,
            'phone' => '082345678901',
            'education_level_id' => $educationLevel->id,
            'pekerjaan' => PekerjaanWali::ASN_PNS->value,
            'jabatan_utama' => JabatanGuru::WALI_KELAS->value,
            'level_lmd' => LevelLMD::LMD_3->value,
            'level_pelatihan_guru' => LevelPelatihanGuru::LEVEL_A->value,
            'photo' => $photo,
            'sertifikat_lmd' => $certLmd,
            'sertifikat_pelatihan' => $certTeaching,
        ];

        $response = $this->post(route('tpa.teachers.store'), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $teacher = Teacher::where('nik', '3273010101900002')->first();
        $this->assertNotNull($teacher);
        $this->assertNotNull($teacher->photo_path);
        $this->assertNotNull($teacher->sertifikat_lmd_path);
        $this->assertNotNull($teacher->sertifikat_pelatihan_path);

        Storage::disk('public')->assertExists($teacher->photo_path);
        Storage::disk('public')->assertExists($teacher->sertifikat_lmd_path);
        Storage::disk('public')->assertExists($teacher->sertifikat_pelatihan_path);
    }

    /** @test */
    public function teacher_creation_requires_mandatory_fields()
    {
        $this->actingAs($this->adminTpa);

        $response = $this->post(route('tpa.teachers.store'), []);

        $response->assertSessionHasErrors([
            'nik',
            'full_name',
            'birth_place',
            'birth_date',
            'gender',
            'phone',
            'jabatan_utama',
            'level_lmd',
            'level_pelatihan_guru',
        ]);
    }

    /** @test */
    public function nik_must_be_16_characters()
    {
        $this->actingAs($this->adminTpa);

        $response = $this->post(route('tpa.teachers.store'), [
            'nik' => '123456', // Too short
            'full_name' => 'Test Teacher',
            'birth_place' => 'Jakarta',
            'birth_date' => '1990-01-01',
            'gender' => Gender::LAKI_LAKI->value,
            'phone' => '081234567890',
            'jabatan_utama' => JabatanGuru::GURU_IQRA->value,
            'level_lmd' => LevelLMD::BELUM_PERNAH->value,
            'level_pelatihan_guru' => LevelPelatihanGuru::BELUM_PERNAH->value,
        ]);

        $response->assertSessionHasErrors('nik');
    }

    /** @test */
    public function nik_must_be_unique()
    {
        $this->actingAs($this->adminTpa);

        $existingTeacher = Teacher::factory()->create([
            'unit_id' => $this->unit->id,
            'nik' => '3273010101900001',
        ]);

        $response = $this->post(route('tpa.teachers.store'), [
            'nik' => '3273010101900001', // Duplicate NIK
            'full_name' => 'Test Teacher',
            'birth_place' => 'Jakarta',
            'birth_date' => '1990-01-01',
            'gender' => Gender::LAKI_LAKI->value,
            'phone' => '081234567890',
            'jabatan_utama' => JabatanGuru::GURU_IQRA->value,
            'level_lmd' => LevelLMD::BELUM_PERNAH->value,
            'level_pelatihan_guru' => LevelPelatihanGuru::BELUM_PERNAH->value,
        ]);

        $response->assertSessionHasErrors('nik');
    }

    /** @test */
    public function admin_tpa_can_view_teacher_detail()
    {
        $this->actingAs($this->adminTpa);

        $teacher = Teacher::factory()->create([
            'unit_id' => $this->unit->id,
        ]);

        $response = $this->get(route('tpa.teachers.show', $teacher));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.teachers.show');
        $response->assertViewHas('teacher');
        $response->assertSee($teacher->full_name);
    }

    /** @test */
    public function admin_tpa_cannot_view_other_unit_teacher()
    {
        $this->actingAs($this->adminTpa);

        // Teacher from other unit
        $otherTeacher = Teacher::factory()->create([
            'unit_id' => $this->otherUnit->id,
        ]);

        $response = $this->get(route('tpa.teachers.show', $otherTeacher));

        $response->assertRedirect(route('tpa.teachers.index'));
        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_tpa_can_view_edit_teacher_form()
    {
        $this->actingAs($this->adminTpa);

        $teacher = Teacher::factory()->create([
            'unit_id' => $this->unit->id,
        ]);

        $response = $this->get(route('tpa.teachers.edit', $teacher));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.teachers.edit');
        $response->assertViewHas('teacher');
        $response->assertSee($teacher->full_name);
    }

    /** @test */
    public function admin_tpa_can_update_teacher()
    {
        $this->actingAs($this->adminTpa);

        $teacher = Teacher::factory()->create([
            'unit_id' => $this->unit->id,
            'full_name' => 'Old Name',
            'jabatan_utama' => JabatanGuru::GURU_IQRA,
        ]);

        $updateData = [
            'nik' => $teacher->nik,
            'full_name' => 'Updated Name',
            'birth_place' => $teacher->birth_place,
            'birth_date' => $teacher->birth_date->format('Y-m-d'),
            'gender' => $teacher->gender->value,
            'phone' => '089999999999',
            'jabatan_utama' => JabatanGuru::KEPALA_UNIT->value,
            'level_lmd' => LevelLMD::LMD_3->value,
            'level_pelatihan_guru' => LevelPelatihanGuru::LEVEL_A->value,
            'is_active' => false,
        ];

        $response = $this->put(route('tpa.teachers.update', $teacher), $updateData);

        $response->assertRedirect(route('tpa.teachers.show', $teacher));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'full_name' => 'Updated Name',
            'phone' => '089999999999',
            'jabatan_utama' => JabatanGuru::KEPALA_UNIT->value,
            'is_active' => false,
        ]);
    }

    /** @test */
    public function admin_tpa_can_update_teacher_files()
    {
        $this->actingAs($this->adminTpa);

        $teacher = Teacher::factory()->create([
            'unit_id' => $this->unit->id,
            'photo_path' => 'teachers/photos/old_photo.jpg',
            'sertifikat_lmd_path' => 'teachers/certificates/lmd/old_cert.pdf',
        ]);

        // Create old files
        Storage::disk('public')->put($teacher->photo_path, 'old photo content');
        Storage::disk('public')->put($teacher->sertifikat_lmd_path, 'old cert content');

        $newPhoto = UploadedFile::fake()->image('new_photo.jpg');
        $newCert = UploadedFile::fake()->create('new_cert.pdf', 500, 'application/pdf');

        $updateData = [
            'nik' => $teacher->nik,
            'full_name' => $teacher->full_name,
            'birth_place' => $teacher->birth_place,
            'birth_date' => $teacher->birth_date->format('Y-m-d'),
            'gender' => $teacher->gender->value,
            'phone' => $teacher->phone,
            'jabatan_utama' => $teacher->jabatan_utama->value,
            'level_lmd' => $teacher->level_lmd->value,
            'level_pelatihan_guru' => $teacher->level_pelatihan_guru->value,
            'photo' => $newPhoto,
            'sertifikat_lmd' => $newCert,
        ];

        $response = $this->put(route('tpa.teachers.update', $teacher), $updateData);

        $response->assertRedirect(route('tpa.teachers.show', $teacher));

        $teacher->refresh();
        $this->assertNotEquals('teachers/photos/old_photo.jpg', $teacher->photo_path);
        $this->assertNotEquals('teachers/certificates/lmd/old_cert.pdf', $teacher->sertifikat_lmd_path);

        Storage::disk('public')->assertExists($teacher->photo_path);
        Storage::disk('public')->assertExists($teacher->sertifikat_lmd_path);
    }

    /** @test */
    public function admin_tpa_cannot_update_other_unit_teacher()
    {
        $this->actingAs($this->adminTpa);

        $otherTeacher = Teacher::factory()->create([
            'unit_id' => $this->otherUnit->id,
        ]);

        $response = $this->put(route('tpa.teachers.update', $otherTeacher), [
            'full_name' => 'Hacked Name',
        ]);

        $response->assertRedirect(route('tpa.teachers.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('teachers', [
            'id' => $otherTeacher->id,
            'full_name' => 'Hacked Name',
        ]);
    }

    /** @test */
    public function admin_tpa_can_delete_teacher()
    {
        $this->actingAs($this->adminTpa);

        $teacher = Teacher::factory()->create([
            'unit_id' => $this->unit->id,
        ]);

        $response = $this->delete(route('tpa.teachers.destroy', $teacher));

        $response->assertRedirect(route('tpa.teachers.index'));
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('teachers', [
            'id' => $teacher->id,
        ]);
    }

    /** @test */
    public function admin_tpa_cannot_delete_other_unit_teacher()
    {
        $this->actingAs($this->adminTpa);

        $otherTeacher = Teacher::factory()->create([
            'unit_id' => $this->otherUnit->id,
        ]);

        $response = $this->delete(route('tpa.teachers.destroy', $otherTeacher));

        $response->assertRedirect(route('tpa.teachers.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('teachers', [
            'id' => $otherTeacher->id,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function ajax_get_cities_returns_cities_for_province()
    {
        $this->actingAs($this->adminTpa);

        $province = Province::create(['name' => 'Sulawesi Selatan']);
        $cities = collect([
            City::create(['province_id' => $province->id, 'name' => 'Makassar']),
            City::create(['province_id' => $province->id, 'name' => 'Parepare']),
            City::create(['province_id' => $province->id, 'name' => 'Palopo']),
        ]);

        $response = $this->get(route('tpa.api.cities', ['province_id' => $province->id]));

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment(['id' => $cities[0]->id]);
    }

    /** @test */
    public function ajax_get_districts_returns_districts_for_city()
    {
        $this->actingAs($this->adminTpa);

        $province = Province::create(['name' => 'Sulawesi Selatan']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Makassar']);
        $districts = collect([
            District::create(['city_id' => $city->id, 'name' => 'Tamalate']),
            District::create(['city_id' => $city->id, 'name' => 'Panakkukang']),
            District::create(['city_id' => $city->id, 'name' => 'Makassar']),
        ]);

        $response = $this->get(route('tpa.api.districts', ['city_id' => $city->id]));

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment(['id' => $districts[0]->id]);
    }

    /** @test */
    public function ajax_get_villages_returns_villages_for_district()
    {
        $this->actingAs($this->adminTpa);

        $province = Province::create(['name' => 'Sulawesi Selatan']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Makassar']);
        $district = District::create(['city_id' => $city->id, 'name' => 'Tamalate']);
        $villages = collect([
            Village::create(['district_id' => $district->id, 'name' => 'Mangasa']),
            Village::create(['district_id' => $district->id, 'name' => 'Balang Baru']),
            Village::create(['district_id' => $district->id, 'name' => 'Jongaya']),
        ]);

        $response = $this->get(route('tpa.api.villages', ['district_id' => $district->id]));

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment(['id' => $villages[0]->id]);
    }

    /** @test */
    public function file_upload_validates_size()
    {
        $this->actingAs($this->adminTpa);

        $largePhoto = UploadedFile::fake()->image('large.jpg')->size(2048); // 2MB

        $response = $this->post(route('tpa.teachers.store'), [
            'nik' => '3273010101900001',
            'full_name' => 'Test Teacher',
            'birth_place' => 'Jakarta',
            'birth_date' => '1990-01-01',
            'gender' => Gender::LAKI_LAKI->value,
            'phone' => '081234567890',
            'jabatan_utama' => JabatanGuru::GURU_IQRA->value,
            'level_lmd' => LevelLMD::BELUM_PERNAH->value,
            'level_pelatihan_guru' => LevelPelatihanGuru::BELUM_PERNAH->value,
            'photo' => $largePhoto,
        ]);

        $response->assertSessionHasErrors('photo');
    }

    /** @test */
    public function file_upload_validates_mime_type()
    {
        $this->actingAs($this->adminTpa);

        $wrongFile = UploadedFile::fake()->create('document.doc', 500);

        $response = $this->post(route('tpa.teachers.store'), [
            'nik' => '3273010101900001',
            'full_name' => 'Test Teacher',
            'birth_place' => 'Jakarta',
            'birth_date' => '1990-01-01',
            'gender' => Gender::LAKI_LAKI->value,
            'phone' => '081234567890',
            'jabatan_utama' => JabatanGuru::GURU_IQRA->value,
            'level_lmd' => LevelLMD::BELUM_PERNAH->value,
            'level_pelatihan_guru' => LevelPelatihanGuru::BELUM_PERNAH->value,
            'photo' => $wrongFile,
        ]);

        $response->assertSessionHasErrors('photo');
    }

    /** @test */
    public function unauthenticated_user_cannot_access_teacher_routes()
    {
        $teacher = Teacher::factory()->create(['unit_id' => $this->unit->id]);

        $this->get(route('tpa.teachers.index'))->assertRedirect(route('login'));
        $this->get(route('tpa.teachers.create'))->assertRedirect(route('login'));
        $this->get(route('tpa.teachers.show', $teacher))->assertRedirect(route('login'));
        $this->get(route('tpa.teachers.edit', $teacher))->assertRedirect(route('login'));
    }

    /** @test */
    public function teacher_model_has_correct_relationships()
    {
        $educationLevel = EducationLevel::factory()->create();
        $province = Province::create(['name' => 'Sulawesi Selatan']);

        $teacher = Teacher::factory()->create([
            'unit_id' => $this->unit->id,
            'education_level_id' => $educationLevel->id,
            'province_id' => $province->id,
        ]);

        $this->assertInstanceOf(Unit::class, $teacher->unit);
        $this->assertInstanceOf(EducationLevel::class, $teacher->educationLevel);
        $this->assertInstanceOf(Province::class, $teacher->province);
    }

    /** @test */
    public function teacher_model_has_correct_accessors()
    {
        $teacher = Teacher::factory()->create([
            'unit_id' => $this->unit->id,
            'birth_date' => now()->subYears(30),
            'tugas_tambahan' => ['admin_operator', 'guru_iqra'],
            'pekerjaan' => [PekerjaanWali::WIRASWASTA->value],
        ]);

        $this->assertEquals(30, $teacher->age);
        $this->assertIsArray($teacher->tugas_tambahan_labels);
        $this->assertCount(2, $teacher->tugas_tambahan_labels);
        $this->assertIsArray($teacher->pekerjaan_labels);
        $this->assertCount(1, $teacher->pekerjaan_labels);
    }

    /** @test */
    public function teacher_model_scopes_work_correctly()
    {
        Teacher::factory()->create([
            'unit_id' => $this->unit->id,
            'is_active' => true,
        ]);

        Teacher::factory()->create([
            'unit_id' => $this->unit->id,
            'is_active' => false,
        ]);

        $activeTeachers = Teacher::active()->get();
        $this->assertCount(1, $activeTeachers);

        $unitTeachers = Teacher::byUnit($this->unit->id)->get();
        $this->assertCount(2, $unitTeachers);
    }
}
