
   FAIL  Tests\Feature\Api\RegionControllerTest
  ⨯ can get provinces
  ⨯ can get cities by province
  ⨯ get cities requires province id
  ⨯ can get districts by city
  ⨯ get districts requires city id
  ⨯ can get villages by district
  ⨯ get villages requires district id
  ⨯ cities are ordered by name

   FAIL  Tests\Feature\CrossRoleFlowTest
  ⨯ complete tpa onboarding flow from creation to santri input
  ⨯ rejected tpa cannot have admin account created
  ⨯ pending tpa cannot have admin account created
  ⨯ superadmin rejection flow with resubmission

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                        0.05s  

   FAIL  Tests\Feature\Lpptka\LpptkaFlowTest
  ⨯ lpptka admin can login and redirected to lpptka dashboard
  ⨯ lpptka admin can access dashboard
  ⨯ lpptka admin cannot access superadmin routes
  ⨯ lpptka admin cannot access tpa routes
  ⨯ lpptka admin can view unit list
  ⨯ lpptka admin can view create unit form
  ⨯ lpptka admin can create new unit
  ⨯ lpptka admin can view unit detail
  ⨯ lpptka admin can edit unit
  ⨯ lpptka admin can update unit
  ⨯ lpptka admin can upload certificate
  ⨯ lpptka admin can view tpa accounts list
  ⨯ lpptka admin can view create tpa account form for approved unit
  ⨯ lpptka admin can create tpa account for approved unit
  ⨯ lpptka admin cannot create tpa account for pending unit
  ⨯ complete lpptka unit creation flow
  ⨯ complete tpa account creation flow

   FAIL  Tests\Feature\RoleAuthenticationTest
  ⨯ guest cannot access superadmin routes
  ⨯ guest cannot access lpptka routes
  ⨯ guest cannot access tpa routes
  ⨯ guest can access login page
  ⨯ superadmin can access superadmin dashboard
  ⨯ superadmin can access unit approval routes
  ⨯ superadmin cannot access lpptka dashboard
  ⨯ superadmin cannot access lpptka units
  ⨯ superadmin cannot access tpa dashboard
  ⨯ superadmin cannot access tpa santri
  ⨯ lpptka admin can access lpptka dashboard
  ⨯ lpptka admin can access units routes
  ⨯ lpptka admin can access tpa accounts routes
  ⨯ lpptka admin cannot access superadmin dashboard
  ⨯ lpptka admin cannot access unit approval
  ⨯ lpptka admin cannot access tpa dashboard
  ⨯ lpptka admin cannot access tpa santri
  ⨯ tpa admin can access tpa dashboard
  ⨯ tpa admin can access santri routes
  ⨯ tpa admin can access own unit profile
  ⨯ tpa admin cannot access superadmin dashboard
  ⨯ tpa admin cannot access unit approval
  ⨯ tpa admin cannot access lpptka dashboard
  ⨯ tpa admin cannot access lpptka units
  ⨯ superadmin login redirects to superadmin dashboard
  ⨯ lpptka admin login redirects to lpptka dashboard
  ⨯ tpa admin login redirects to tpa dashboard
  ⨯ inactive user cannot login
  ⨯ superadmin can logout
  ⨯ lpptka admin can logout
  ⨯ tpa admin can logout

   FAIL  Tests\Feature\SuperAdmin\SuperAdminFlowTest
  ⨯ superadmin can login and redirected to superadmin dashboard
  ⨯ superadmin can access dashboard
  ⨯ superadmin cannot access lpptka routes
  ⨯ superadmin cannot access tpa routes
  ⨯ superadmin can view unit approval list
  ⨯ superadmin can view unit approval details
  ⨯ superadmin can approve pending unit
  ⨯ superadmin can reject pending unit
  ⨯ superadmin cannot approve already approved unit
  ⨯ complete superadmin approval flow
  ⨯ superadmin dashboard shows correct statistics

   FAIL  Tests\Feature\Tpa\TpaFlowTest
  ⨯ tpa admin can login and redirected to tpa dashboard
  ⨯ tpa admin can access dashboard
  ⨯ tpa admin cannot access superadmin routes
  ⨯ tpa admin cannot access lpptka routes
  ⨯ tpa admin can view santri list
  ⨯ tpa admin can view create santri form
  ⨯ tpa admin can create new santri
  ⨯ tpa admin can view santri detail
  ⨯ tpa admin can edit santri
  ⨯ tpa admin can update santri
  ⨯ tpa admin can delete santri
  ⨯ tpa admin can view unit profile
  ⨯ tpa admin without unit sees no unit page
  ⨯ complete tpa santri management flow
  ⨯ tpa dashboard shows correct statistics
  ⨯ tpa admin cannot access santri from other unit
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Api\RegionControllerTest > can get…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Api/RegionControllerTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Api\RegionControllerTest > can get…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Api/RegionControllerTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Api\RegionControllerTest > get citi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Api/RegionControllerTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Api\RegionControllerTest > can get…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Api/RegionControllerTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Api\RegionControllerTest > get dist…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Api/RegionControllerTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Api\RegionControllerTest > can get…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Api/RegionControllerTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Api\RegionControllerTest > get vill…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Api/RegionControllerTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Api\RegionControllerTest > cities a…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Api/RegionControllerTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\CrossRoleFlowTest > complete tpa on…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/CrossRoleFlowTest.php:54

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\CrossRoleFlowTest > rejected tpa ca…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/CrossRoleFlowTest.php:54

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\CrossRoleFlowTest > pending tpa can…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/CrossRoleFlowTest.php:54

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\CrossRoleFlowTest > superadmin reje…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/CrossRoleFlowTest.php:54

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > lpptka admi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > complete lp…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Lpptka\LpptkaFlowTest > complete tp…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Lpptka/LpptkaFlowTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > guest cann…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > guest cann…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > guest cann…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > guest can…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > superadmin…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > superadmin…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > superadmin…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > superadmin…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > superadmin…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > superadmin…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > lpptka adm…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > lpptka adm…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > lpptka adm…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > lpptka adm…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > lpptka adm…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > lpptka adm…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > lpptka adm…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > tpa admin…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > tpa admin…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > tpa admin…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > tpa admin…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > tpa admin…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > tpa admin…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > tpa admin…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > superadmin…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > lpptka adm…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > tpa admin…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > inactive u…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > superadmin…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > lpptka adm…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RoleAuthenticationTest > tpa admin…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/RoleAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > com…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SuperAdmin\SuperAdminFlowTest > sup…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/SuperAdmin/SuperAdminFlowTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can log…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can acc…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin cannot…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin cannot…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can vie…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can vie…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can cre…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can vie…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can edi…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can upd…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can del…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin can vie…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin without…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > complete tpa sant…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa dashboard sho…  QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Tpa\TpaFlowTest > tpa admin cannot…   QueryException   
  SQLSTATE[HY000]: General error: 1 near "ALTER": syntax error (Connection: sqlite, Database: :memory:, SQL: ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL)

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

      [2m+8 vendor frames [22m
  9   database/migrations/2026_01_30_200000_make_birth_fields_nullable_in_persons_table.php:32
      [2m+37 vendor frames [22m
  47  tests/Feature/Tpa/TpaFlowTest.php:50


  Tests:    87 failed, 2 passed (2 assertions)
  Duration: 6.43s

