
   PASS  Tests\Feature\Api\RegionControllerTest
  ✓ can get provinces                                                    0.36s  
  ✓ can get cities by province                                           0.02s  
  ✓ get cities requires province id                                      0.02s  
  ✓ can get districts by city                                            0.01s  
  ✓ get districts requires city id                                       0.01s  
  ✓ can get villages by district                                         0.02s  
  ✓ get villages requires district id                                    0.02s  
  ✓ cities are ordered by name                                           0.02s  

   PASS  Tests\Feature\CrossRoleFlowTest
  ✓ complete tpa onboarding flow from creation to santri input           0.19s  
  ✓ rejected tpa cannot have admin account created                       0.03s  
  ✓ pending tpa cannot have admin account created                        0.03s  
  ✓ superadmin rejection flow with resubmission                          0.04s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                        0.02s  

   PASS  Tests\Feature\Lpptka\LpptkaFlowTest
  ✓ lpptka admin can login and redirected to lpptka dashboard            0.02s  
  ✓ lpptka admin can access dashboard                                    0.03s  
  ✓ lpptka admin cannot access superadmin routes                         0.02s  
  ✓ lpptka admin cannot access tpa routes                                0.02s  
  ✓ lpptka admin can view unit list                                      0.03s  
  ✓ lpptka admin can view create unit form                               0.03s  
  ✓ lpptka admin can create new unit                                     0.03s  
  ✓ lpptka admin can view unit detail                                    0.03s  
  ✓ lpptka admin can edit unit                                           0.03s  
  ✓ lpptka admin can update unit                                         0.03s  
  ✓ lpptka admin can upload certificate                                  0.02s  
  ✓ lpptka admin can view tpa accounts list                              0.02s  
  ✓ lpptka admin can view create tpa account form for approved unit      0.03s  
  ✓ lpptka admin can create tpa account for approved unit                0.03s  
  ✓ lpptka admin cannot create tpa account for pending unit              0.02s  
  ✓ complete lpptka unit creation flow                                   0.06s  
  ✓ complete tpa account creation flow                                   0.05s  
  ✓ lpptka admin can view profile                                        0.03s  
  ✓ lpptka admin can update profile                                      0.02s  
  ✓ lpptka admin profile requires full name and email                    0.02s  
  ✓ lpptka admin email must be unique                                    0.02s  
  ✓ lpptka admin can update password                                     0.03s  
  ✓ lpptka admin password update requires correct current password       0.02s  
  ✓ lpptka admin password update requires confirmation                   0.02s  
  ✓ lpptka admin password must be at least 8 characters                  0.02s  
  ✓ lpptka admin profile shows correct statistics                        0.03s  
  ✓ non lpptka admin cannot access profile                               0.02s  

   PASS  Tests\Feature\RoleAuthenticationTest
  ✓ guest cannot access superadmin routes                                0.05s  
  ✓ guest cannot access lpptka routes                                    0.03s  
  ✓ guest cannot access tpa routes                                       0.03s  
  ✓ guest can access login page                                          0.03s  
  ✓ superadmin can access superadmin dashboard                           0.03s  
  ✓ superadmin can access unit approval routes                           0.03s  
  ✓ superadmin cannot access lpptka dashboard                            0.02s  
  ✓ superadmin cannot access lpptka units                                0.03s  
  ✓ superadmin cannot access tpa dashboard                               0.03s  
  ✓ superadmin cannot access tpa santri                                  0.03s  
  ✓ lpptka admin can access lpptka dashboard                             0.03s  
  ✓ lpptka admin can access units routes                                 0.03s  
  ✓ lpptka admin can access tpa accounts routes                          0.03s  
  ✓ lpptka admin cannot access superadmin dashboard                      0.02s  
  ✓ lpptka admin cannot access unit approval                             0.03s  
  ✓ lpptka admin cannot access tpa dashboard                             0.03s  
  ✓ lpptka admin cannot access tpa santri                                0.03s  
  ✓ tpa admin can access tpa dashboard                                   0.03s  
  ✓ tpa admin can access santri routes                                   0.03s  
  ✓ tpa admin can access own unit profile                                0.03s  
  ✓ tpa admin cannot access superadmin dashboard                         0.03s  
  ✓ tpa admin cannot access unit approval                                0.03s  
  ✓ tpa admin cannot access lpptka dashboard                             0.03s  
  ✓ tpa admin cannot access lpptka units                                 0.03s  
  ✓ superadmin login redirects to superadmin dashboard                   0.03s  
  ✓ lpptka admin login redirects to lpptka dashboard                     0.03s  
  ✓ tpa admin login redirects to tpa dashboard                           0.03s  
  ✓ inactive user cannot login                                           0.03s  
  ✓ superadmin can logout                                                0.02s  
  ✓ lpptka admin can logout                                              0.03s  
  ✓ tpa admin can logout                                                 0.02s  

   PASS  Tests\Feature\SuperAdmin\SuperAdminFlowTest
  ✓ superadmin can login and redirected to superadmin dashboard          0.05s  
  ✓ superadmin can access dashboard                                      0.03s  
  ✓ superadmin cannot access lpptka routes                               0.02s  
  ✓ superadmin cannot access tpa routes                                  0.02s  
  ✓ superadmin can view unit approval list                               0.03s  
  ✓ superadmin can view unit approval details                            0.02s  
  ✓ superadmin can approve pending unit                                  0.02s  
  ✓ superadmin can reject pending unit                                   0.02s  
  ✓ superadmin cannot approve already approved unit                      0.02s  
  ✓ complete superadmin approval flow                                    0.05s  
  ✓ superadmin dashboard shows correct statistics                        0.03s  

   FAIL  Tests\Feature\TeacherManagementTest
  ✓ admin tpa can view teacher list                                      0.05s  
  ✓ admin tpa can view create teacher form                               0.03s  
  ⨯ admin tpa can create teacher with valid data                         0.29s  
  ⨯ admin tpa can create teacher with photo and certificates             0.22s  
  ⨯ teacher creation requires mandatory fields                           0.23s  
  ⨯ nik must be 16 characters                                            0.23s  
  ⨯ nik must be unique                                                   0.22s  
  ✓ admin tpa can view teacher detail                                    0.03s  
  ✓ admin tpa cannot view other unit teacher                             0.03s  
  ✓ admin tpa can view edit teacher form                                 0.04s  
  ⨯ admin tpa can update teacher                                         0.23s  
  ⨯ admin tpa can update teacher files                                   0.24s  
  ✓ admin tpa cannot update other unit teacher                           0.03s  
  ✓ admin tpa can delete teacher                                         0.03s  
  ✓ admin tpa cannot delete other unit teacher                           0.03s  
  ✓ ajax get cities returns cities for province                          0.03s  
  ✓ ajax get districts returns districts for city                        0.04s  
  ✓ ajax get villages returns villages for district                      0.03s  
  ⨯ file upload validates size                                           0.27s  
  ⨯ file upload validates mime type                                      0.23s  
  ✓ unauthenticated user cannot access teacher routes                    0.03s  
  ✓ teacher model has correct relationships                              0.03s  
  ✓ teacher model has correct accessors                                  0.03s  
  ✓ teacher model scopes work correctly                                  0.03s  

   PASS  Tests\Feature\Tpa\TpaFlowTest
  ✓ tpa admin can login and redirected to tpa dashboard                  0.04s  
  ✓ tpa admin can access dashboard                                       0.03s  
  ✓ tpa admin cannot access superadmin routes                            0.02s  
  ✓ tpa admin cannot access lpptka routes                                0.02s  
  ✓ tpa admin can view santri list                                       0.03s  
  ✓ tpa admin can view create santri form                                0.03s  
  ✓ tpa admin can create new santri                                      0.03s  
  ✓ tpa admin can view santri detail                                     0.03s  
  ✓ tpa admin can edit santri                                            0.03s  
  ✓ tpa admin can update santri                                          0.03s  
  ✓ tpa admin can delete santri                                          0.02s  
  ✓ tpa admin can view unit profile                                      0.03s  
  ✓ tpa admin without unit sees no unit page                             0.02s  
  ✓ complete tpa santri management flow                                  0.08s  
  ✓ tpa dashboard shows correct statistics                               0.03s  
  ✓ tpa admin cannot access santri from other unit                       0.02s  
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa can create teache…   
  Expected response status code [201, 301, 302, 303, 307, 308] but received 500.
Failed asserting that false is true.

The following exception occurred during the last request:

----------------------------------------------------------------------------------

Class "App\Http\Controllers\Enum" not found

  at tests/Feature/TeacherManagementTest.php:132
    128▕         ];
    129▕ 
    130▕         $response = $this->post(route('tpa.teachers.store'), $teacherData);
    131▕ 
  ➜ 132▕         $response->assertRedirect();
    133▕         $response->assertSessionHas('success');
    134▕ 
    135▕         $this->assertDatabaseHas('teachers', [
    136▕             'unit_id' => $this->unit->id,

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa can create teache…   
  Expected response status code [201, 301, 302, 303, 307, 308] but received 500.
Failed asserting that false is true.

