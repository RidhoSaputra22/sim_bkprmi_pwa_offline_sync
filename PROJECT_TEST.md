
   

   PASS  Tests\Feature\Api\RegionControllerTest
  ✓ can get provinces                                                    0.36s  
  ✓ can get cities by province                                           0.02s  
  ✓ get cities requires province id                                      0.02s  
  ✓ can get districts by city                                            0.02s  
  ✓ get districts requires city id                                       0.01s  
  ✓ can get villages by district                                         0.01s  
  ✓ get villages requires district id                                    0.01s  
  ✓ cities are ordered by name                                           0.01s  

   PASS  Tests\Feature\CrossRoleFlowTest
  ✓ complete tpa onboarding flow from creation to santri input           0.18s  
  ✓ rejected tpa cannot have admin account created                       0.02s  
  ✓ pending tpa cannot have admin account created                        0.02s  
  ✓ superadmin rejection flow with resubmission                          0.04s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                        0.02s  

   PASS  Tests\Feature\Lpptka\LpptkaFlowTest
  ✓ lpptka admin can login and redirected to lpptka dashboard            0.02s  
  ✓ lpptka admin can access dashboard                                    0.02s  
  ✓ lpptka admin cannot access superadmin routes                         0.03s  
  ✓ lpptka admin cannot access tpa routes                                0.02s  
  ✓ lpptka admin can view unit list                                      0.03s  
  ✓ lpptka admin can view create unit form                               0.03s  
  ✓ lpptka admin can create new unit                                     0.03s  
  ✓ lpptka admin can view unit detail                                    0.03s  
  ✓ lpptka admin can edit unit                                           0.03s  
  ✓ lpptka admin can update unit                                         0.03s  
  ✓ lpptka admin can upload certificate                                  0.02s  
  ✓ lpptka admin can view tpa accounts list                              0.02s  
  ✓ lpptka admin can view create tpa account form for approved unit      0.02s  
  ✓ lpptka admin can create tpa account for approved unit                0.02s  
  ✓ lpptka admin cannot create tpa account for pending unit              0.02s  
  ✓ complete lpptka unit creation flow                                   0.05s  
  ✓ complete tpa account creation flow                                   0.05s  

   PASS  Tests\Feature\RoleAuthenticationTest
  ✓ guest cannot access superadmin routes                                0.04s  
  ✓ guest cannot access lpptka routes                                    0.02s  
  ✓ guest cannot access tpa routes                                       0.03s  
  ✓ guest can access login page                                          0.03s  
  ✓ superadmin can access superadmin dashboard                           0.03s  
  ✓ superadmin can access unit approval routes                           0.05s  
  ✓ superadmin cannot access lpptka dashboard                            0.02s  
  ✓ superadmin cannot access lpptka units                                0.02s  
  ✓ superadmin cannot access tpa dashboard                               0.02s  
  ✓ superadmin cannot access tpa santri                                  0.03s  
  ✓ lpptka admin can access lpptka dashboard                             0.03s  
  ✓ lpptka admin can access units routes                                 0.04s  
  ✓ lpptka admin can access tpa accounts routes                          0.03s  
  ✓ lpptka admin cannot access superadmin dashboard                      0.03s  
  ✓ lpptka admin cannot access unit approval                             0.03s  
  ✓ lpptka admin cannot access tpa dashboard                             0.02s  
  ✓ lpptka admin cannot access tpa santri                                0.03s  
  ✓ tpa admin can access tpa dashboard                                   0.03s  
  ✓ tpa admin can access santri routes                                   0.03s  
  ✓ tpa admin can access own unit profile                                0.03s  
  ✓ tpa admin cannot access superadmin dashboard                         0.02s  
  ✓ tpa admin cannot access unit approval                                0.03s  
  ✓ tpa admin cannot access lpptka dashboard                             0.03s  
  ✓ tpa admin cannot access lpptka units                                 0.03s  
  ✓ superadmin login redirects to superadmin dashboard                   0.03s  
  ✓ lpptka admin login redirects to lpptka dashboard                     0.03s  
  ✓ tpa admin login redirects to tpa dashboard                           0.03s  
  ✓ inactive user cannot login                                           0.03s  
  ✓ superadmin can logout                                                0.03s  
  ✓ lpptka admin can logout                                              0.03s  
  ✓ tpa admin can logout                                                 0.03s  

   PASS  Tests\Feature\SuperAdmin\SuperAdminFlowTest
  ✓ superadmin can login and redirected to superadmin dashboard          0.05s  
  ✓ superadmin can access dashboard                                      0.03s  
  ✓ superadmin cannot access lpptka routes                               0.02s  
  ✓ superadmin cannot access tpa routes                                  0.02s  
  ✓ superadmin can view unit approval list                               0.04s  
  ✓ superadmin can view unit approval details                            0.05s  
  ✓ superadmin can approve pending unit                                  0.04s  
  ✓ superadmin can reject pending unit                                   0.04s  
  ✓ superadmin cannot approve already approved unit                      0.04s  
  ✓ complete superadmin approval flow                                    0.04s  
  ✓ superadmin dashboard shows correct statistics                        0.03s  

   FAIL  Tests\Feature\TeacherManagementTest
  ⨯ admin tpa can view teacher list
  ⨯ admin tpa can view create teacher form
  ⨯ admin tpa can create teacher with valid data
  ⨯ admin tpa can create teacher with photo and certificates
  ⨯ teacher creation requires mandatory fields
  ⨯ nik must be 16 characters
  ⨯ nik must be unique
  ⨯ admin tpa can view teacher detail
  ⨯ admin tpa cannot view other unit teacher
  ⨯ admin tpa can view edit teacher form
  ⨯ admin tpa can update teacher
  ⨯ admin tpa can update teacher files
  ⨯ admin tpa cannot update other unit teacher
  ⨯ admin tpa can delete teacher
  ⨯ admin tpa cannot delete other unit teacher
  ⨯ ajax get cities returns cities for province
  ⨯ ajax get districts returns districts for city
  ⨯ ajax get villages returns villages for district
  ⨯ file upload validates size
  ⨯ file upload validates mime type
  ⨯ unauthenticated user cannot access teacher routes
  ⨯ teacher model has correct relationships
  ⨯ teacher model has correct accessors
  ⨯ teacher model scopes work correctly

   PASS  Tests\Feature\Tpa\TpaFlowTest
  ✓ tpa admin can login and redirected to tpa dashboard                  0.03s  
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
  ✓ tpa admin can view unit profile                                      0.02s  
  ✓ tpa admin without unit sees no unit page                             0.02s  
  ✓ complete tpa santri management flow                                  0.08s  
  ✓ tpa dashboard shows correct statistics                               0.03s  
  ✓ tpa admin cannot access santri from other unit                       0.03s  
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > teacher cre…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > nik must be…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > nik must be…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > admin tpa c…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > ajax get ci…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > ajax get di…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > ajax get vi…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > file upload…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > file upload…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > unauthentic…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > teacher mod…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > teacher mod…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\TeacherManagementTest > teacher mod…  QueryException   
  SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: user_roles.role (Connection: sqlite, Database: :memory:, SQL: insert into "user_roles" ("user_id") values (1))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
    834▕             $exceptionType = $this->isUniqueConstraintError($e)
    835▕                 ? UniqueConstraintViolationException::class
    836▕                 : QueryException::class;
    837▕ 
  ➜ 838▕             throw new $exceptionType(
    839▕                 $this->getNameWithReadWriteType(),
    840▕                 $query,
    841▕                 $this->prepareBindings($bindings),
    842▕                 $e,

      [2m+16 vendor frames [22m
  17  tests/Feature/TeacherManagementTest.php:49


  Tests:    24 failed, 89 passed (262 assertions)
  Duration: 3.44s

