<?php

namespace Database\Factories;

use App\Enum\Gender;
use App\Enum\JabatanGuru;
use App\Enum\LevelLMD;
use App\Enum\LevelPelatihanGuru;
use App\Enum\PekerjaanWali;
use App\Models\EducationLevel;
use App\Models\Province;
use App\Models\Teacher;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        $gender = Arr::random(Gender::cases());
        $firstName = $gender === Gender::LAKI_LAKI
            ? $this->faker->firstNameMale()
            : $this->faker->firstNameFemale();

        return [
            'unit_id' => Unit::query()->inRandomOrder()->value('id') ?? Unit::factory(),
            'nik' => $this->faker->unique()->numerify('################'), // 16 digits
            'full_name' => $firstName . ' ' . $this->faker->lastName(),
            'birth_place' => $this->faker->city(),
            'birth_date' => $this->faker->dateTimeBetween('-60 years', '-20 years'),
            'gender' => $gender->value,
            'phone' => $this->faker->numerify('08##########'),
            'education_level_id' => EducationLevel::query()->inRandomOrder()->value('id')
                ?? EducationLevel::factory(),
            'pekerjaan' => [Arr::random(PekerjaanWali::cases())->value],
            'province_id' => Province::query()->inRandomOrder()->value('id'),
            'jalan' => $this->faker->streetAddress(),
            'rt' => str_pad($this->faker->numberBetween(1, 20), 3, '0', STR_PAD_LEFT),
            'rw' => str_pad($this->faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
            'jabatan_utama' => Arr::random(JabatanGuru::cases())->value,
            'tugas_tambahan' => [],
            'level_lmd' => Arr::random(LevelLMD::cases())->value,
            'level_pelatihan_guru' => Arr::random(LevelPelatihanGuru::cases())->value,
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the teacher is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the teacher has LMD certification.
     */
    public function withLMD(LevelLMD $level = LevelLMD::LMD_1): static
    {
        return $this->state(fn (array $attributes) => [
            'level_lmd' => $level->value,
            'sertifikat_lmd_path' => 'teachers/certificates/lmd/test_cert.pdf',
        ]);
    }

    /**
     * Indicate that the teacher has teaching certification.
     */
    public function withTeachingCertification(LevelPelatihanGuru $level = LevelPelatihanGuru::LEVEL_A): static
    {
        return $this->state(fn (array $attributes) => [
            'level_pelatihan_guru' => $level->value,
            'sertifikat_pelatihan_path' => 'teachers/certificates/teaching/test_cert.pdf',
        ]);
    }

    /**
     * Indicate that the teacher has a photo.
     */
    public function withPhoto(): static
    {
        return $this->state(fn (array $attributes) => [
            'photo_path' => 'teachers/photos/test_photo.jpg',
        ]);
    }

    /**
     * Indicate that the teacher is a class teacher.
     */
    public function classTeacher(): static
    {
        return $this->state(fn (array $attributes) => [
            'jabatan_utama' => JabatanGuru::WALI_KELAS->value,
        ]);
    }

    /**
     * Indicate that the teacher is a head of unit.
     */
    public function headOfUnit(): static
    {
        return $this->state(fn (array $attributes) => [
            'jabatan_utama' => JabatanGuru::KEPALA_UNIT->value,
        ]);
    }
}
