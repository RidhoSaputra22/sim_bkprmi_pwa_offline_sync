
   FAIL  Tests\Feature\Admin\ActivityControllerTest
  ⨯ guest cannot access activities index                                 0.19s  
  ⨯ authenticated user can access activities index                       0.01s  
  ⨯ authenticated user can access create activity page                   0.01s  
  ⨯ authenticated user can store new activity                            0.01s  
  ⨯ store activity requires validation                                   0.01s  
  ⨯ authenticated user can view activity details                         0.01s  
  ⨯ authenticated user can access edit activity page                     0.01s  
  ⨯ authenticated user can update activity                               0.01s  
  ⨯ authenticated user can delete activity                               0.01s  
  ⨯ activities index can filter by unit                                  0.01s  
  ⨯ activities index can search by name                                  0.01s  

   FAIL  Tests\Feature\Admin\AuthenticationTest
  ✓ login page can be rendered                                           0.03s  
  ⨯ users can authenticate with valid credentials                        0.02s  
  ✓ users cannot authenticate with invalid credentials                   0.21s  
  ✓ inactive users cannot authenticate                                   0.01s  
  ✓ users can logout                                                     0.01s  

   FAIL  Tests\Feature\Admin\DashboardControllerTest
  ⨯ guest cannot access dashboard                                        0.01s  
  ⨯ authenticated user can access dashboard                              0.01s  
  ⨯ dashboard displays statistics                                        0.01s  

   FAIL  Tests\Feature\Admin\SantriControllerTest
  ⨯ guest cannot access santri index                                     0.01s  
  ⨯ authenticated user can access santri index                           0.01s  
  ⨯ authenticated user can access create santri page                     0.01s  
  ⨯ authenticated user can store new santri                              0.01s  
  ⨯ store santri requires validation                                     0.01s  
  ⨯ nik must be 16 digits                                                0.01s  
  ⨯ authenticated user can view santri details                           0.01s  
  ⨯ authenticated user can access edit santri page                       0.01s  
  ⨯ authenticated user can update santri                                 0.01s  
  ⨯ authenticated user can delete santri                                 0.01s  
  ⨯ santri index can filter by jenjang                                   0.01s  
  ⨯ santri index can search by name                                      0.01s  

   FAIL  Tests\Feature\Admin\UnitControllerTest
  ⨯ guest cannot access units index                                      0.01s  
  ⨯ authenticated user can access units index                            0.01s  
  ⨯ authenticated user can access create unit page                       0.01s  
  ⨯ authenticated user can store new unit                                0.01s  
  ⨯ store unit requires validation                                       0.01s  
  ⨯ unit number must be unique                                           0.01s  
  ⨯ authenticated user can view unit details                             0.02s  
  ⨯ authenticated user can access edit unit page                         0.01s  
  ⨯ authenticated user can update unit                                   0.02s  
  ⨯ authenticated user can delete unit                                   0.01s  
  ⨯ units index can filter by tipe lokasi                                0.01s  
  ⨯ units index can search by name                                       0.01s  

   FAIL  Tests\Feature\Admin\UserFlowTest
  ✓ user can visit login page and see login form                         0.02s  
  ⨯ user can login with valid credentials and redirected to dashboard    0.01s  
  ✓ user cannot login with wrong password                                0.21s  
  ⨯ user can navigate to santri create form and see all fields           0.01s  
  ⨯ user can input complete santri data and submit form                  0.01s  
  ⨯ user sees validation errors when submitting incomplete santri form   0.01s  
  ⨯ user can view santri list after creating data                        0.01s  
  ⨯ user can search santri by name                                       0.01s  
  ⨯ user can edit existing santri data                                   0.01s  
  ⨯ user can navigate to unit create form                                0.01s  
  ⨯ user can input complete unit data and submit form                    0.01s  
  ⨯ user sees error when creating unit with duplicate number             0.01s  
  ⨯ user can filter units by location type                               0.02s  
  ⨯ user can create new activity for unit                                0.01s  
  ⨯ user can view activity details                                       0.01s  
  ⨯ complete user journey login create unit create santri create activi… 0.01s  

   PASS  Tests\Feature\Api\RegionControllerTest
  ✓ can get provinces                                                    0.02s  
  ✓ can get cities by province                                           0.01s  
  ✓ get cities requires province id                                      0.01s  
  ✓ can get districts by city                                            0.01s  
  ✓ get districts requires city id                                       0.01s  
  ✓ can get villages by district                                         0.01s  
  ✓ get villages requires district id                                    0.01s  
  ✓ cities are ordered by name                                           0.01s  

   PASS  Tests\Feature\CrossRoleFlowTest
  ✓ complete tpa onboarding flow from creation to santri input           0.10s  
  ✓ rejected tpa cannot have admin account created                       0.01s  
  ✓ pending tpa cannot have admin account created                        0.01s  
  ✓ superadmin rejection flow with resubmission                          0.03s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                        0.01s  

   PASS  Tests\Feature\Lpptka\LpptkaFlowTest
  ✓ lpptka admin can login and redirected to lpptka dashboard            0.01s  
  ✓ lpptka admin can access dashboard                                    0.01s  
  ✓ lpptka admin cannot access superadmin routes                         0.01s  
  ✓ lpptka admin cannot access tpa routes                                0.01s  
  ✓ lpptka admin can view unit list                                      0.02s  
  ✓ lpptka admin can view create unit form                               0.01s  
  ✓ lpptka admin can create new unit                                     0.02s  
  ✓ lpptka admin can view unit detail                                    0.02s  
  ✓ lpptka admin can edit unit                                           0.02s  
  ✓ lpptka admin can update unit                                         0.02s  
  ✓ lpptka admin can upload certificate                                  0.01s  
  ✓ lpptka admin can view tpa accounts list                              0.02s  
  ✓ lpptka admin can view create tpa account form for approved unit      0.02s  
  ✓ lpptka admin can create tpa account for approved unit                0.02s  
  ✓ lpptka admin cannot create tpa account for pending unit              0.01s  
  ✓ complete lpptka unit creation flow                                   0.04s  
  ✓ complete tpa account creation flow                                   0.03s  

   FAIL  Tests\Feature\Member\ActivityControllerTest
  ⨯ guest cannot access activities index
  ⨯ member can access activities index
  ⨯ activities index returns activities with unit
  ⨯ activities can be searched by title
  ⨯ activities can be searched by description
  ⨯ activities can be filtered by unit id
  ⨯ activities can be filtered by activity date
  ⨯ activities are paginated with 15 per page
  ⨯ activities pagination can navigate to second page
  ⨯ guest cannot access activity show
  ⨯ member can view activity detail
  ⨯ activity show loads unit relationship
  ⨯ activity show loads created by relationship
  ⨯ activity show returns 404 for non existent activity
  ⨯ guest cannot access activity logs
  ⨯ member can view activity logs
  ⨯ activity logs returns activity with unit
  ⨯ activity logs returns logs variable
  ⨯ activity logs are paginated with 10 per page
  ⨯ activity logs returns 404 for non existent activity

   FAIL  Tests\Feature\Member\ActivityTest
  ⨯ guest cannot access activities page
  ⨯ member can view activities list
  ⨯ activities page displays activities
  ⨯ activities can be filtered by unit
  ⨯ member can view activity detail
  ⨯ activities are paginated

   FAIL  Tests\Feature\Member\MemberAuthenticationTest
  ⨯ guest is redirected to login for all member routes                   0.01s  
  ⨯ authenticated user can access member dashboard                       0.01s  
  ⨯ inactive user can still access member pages                          0.01s  
  ⨯ admin can also access member pages                                   0.01s  
  ⨯ user can logout from member area                                     0.01s  
  ⨯ login redirects to intended page                                     0.01s  

   FAIL  Tests\Feature\Member\MemberDashboardControllerTest
  ⨯ guest cannot access member dashboard
  ⨯ member can access dashboard
  ⨯ admin can also access member dashboard
  ⨯ dashboard returns total units count
  ⨯ dashboard returns total activities count
  ⨯ dashboard returns recent activities limited to five
  ⨯ dashboard recent activities ordered by latest
  ⨯ dashboard activities eager load unit relationship
  ⨯ dashboard shows zero when no data exists
  ⨯ dashboard displays quick action links

   FAIL  Tests\Feature\Member\MemberDashboardTest
  ⨯ guest cannot access member dashboard
  ⨯ authenticated member can access dashboard
  ⨯ dashboard displays statistics
  ⨯ dashboard displays recent activities
  ⨯ dashboard has quick action links

   FAIL  Tests\Feature\Member\OrganizationControllerTest
  ⨯ guest cannot access organization index
  ⨯ member can access organization index
  ⨯ organization index returns regions with units
  ⨯ organization index returns statistics
  ⨯ organization statistics contains total units
  ⨯ organization statistics contains total regions
  ⨯ organization statistics contains total santri
  ⨯ organization statistics contains total guru
  ⨯ organization statistics zero when no data
  ⨯ guest cannot access unit detail
  ⨯ member can view unit detail
  ⨯ unit detail loads region relationship
  ⨯ unit detail loads village relationship
  ⨯ unit detail returns 404 for non existent unit
  ⨯ unit detail displays unit information
  ⨯ guest cannot access organization structure
  ⨯ member can view organization structure
  ⨯ organization structure returns regions
  ⨯ organization structure regions include units
  ⨯ organization structure displays hierarchy

   FAIL  Tests\Feature\Member\OrganizationTest
  ⨯ guest cannot access organization page
  ⨯ member can view organization info
  ⨯ organization page displays regions
  ⨯ organization page displays units
  ⨯ organization page displays statistics
  ⨯ member can view unit detail
  ⨯ member can view organization structure

   FAIL  Tests\Feature\Member\ReportControllerTest
  ⨯ guest cannot access reports index
  ⨯ member can access reports index
  ⨯ reports index page renders successfully
  ⨯ guest cannot download santri report
  ⨯ download santri report requires format
  ⨯ download santri report validates format options
  ⨯ download santri report validates unit id exists
  ⨯ download santri report accepts valid unit id
  ⨯ download santri report excel returns error
  ⨯ guest cannot download activity report
  ⨯ download activity report requires format
  ⨯ download activity report validates format options
  ⨯ download activity report validates unit id exists
  ⨯ download activity report validates date range
  ⨯ download activity report accepts valid date range
  ⨯ download activity report excel returns error
  ⨯ guest cannot download unit report
  ⨯ download unit report requires format
  ⨯ download unit report validates format options
  ⨯ download unit report validates region id exists
  ⨯ download unit report accepts valid region id
  ⨯ download unit report excel returns error
  ⨯ guest cannot access print report
  ⨯ print report requires type
  ⨯ print report validates type options
  ⨯ print santri report returns view
  ⨯ print activity report returns view
  ⨯ print unit report returns view
  ⨯ print santri report can filter by unit
  ⨯ print activity report can filter by unit
  ⨯ print activity report can filter by date range
  ⨯ print unit report can filter by region

   FAIL  Tests\Feature\Member\ReportTest
  ⨯ guest cannot access reports page
  ⨯ member can view reports page
  ⨯ reports page shows available report types
  ⨯ download santri report requires authentication
  ⨯ download activity report requires authentication
  ⨯ download unit report requires authentication
  ⨯ print report requires authentication

   PASS  Tests\Feature\RoleAuthenticationTest
  ✓ guest cannot access superadmin routes                                0.02s  
  ✓ guest cannot access lpptka routes                                    0.02s  
  ✓ guest cannot access tpa routes                                       0.02s  
  ✓ guest can access login page                                          0.02s  
  ✓ superadmin can access superadmin dashboard                           0.02s  
  ✓ superadmin can access unit approval routes                           0.02s  
  ✓ superadmin cannot access lpptka dashboard                            0.02s  
  ✓ superadmin cannot access lpptka units                                0.02s  
  ✓ superadmin cannot access tpa dashboard                               0.02s  
  ✓ superadmin cannot access tpa santri                                  0.02s  
  ✓ lpptka admin can access lpptka dashboard                             0.03s  
  ✓ lpptka admin can access units routes                                 0.02s  
  ✓ lpptka admin can access tpa accounts routes                          0.02s  
  ✓ lpptka admin cannot access superadmin dashboard                      0.01s  
  ✓ lpptka admin cannot access unit approval                             0.01s  
  ✓ lpptka admin cannot access tpa dashboard                             0.01s  
  ✓ lpptka admin cannot access tpa santri                                0.01s  
  ✓ tpa admin can access tpa dashboard                                   0.02s  
  ✓ tpa admin can access santri routes                                   0.02s  
  ✓ tpa admin can access own unit profile                                0.02s  
  ✓ tpa admin cannot access superadmin dashboard                         0.01s  
  ✓ tpa admin cannot access unit approval                                0.01s  
  ✓ tpa admin cannot access lpptka dashboard                             0.01s  
  ✓ tpa admin cannot access lpptka units                                 0.01s  
  ✓ superadmin login redirects to superadmin dashboard                   0.02s  
  ✓ lpptka admin login redirects to lpptka dashboard                     0.02s  
  ✓ tpa admin login redirects to tpa dashboard                           0.02s  
  ✓ inactive user cannot login                                           0.02s  
  ✓ superadmin can logout                                                0.01s  
  ✓ lpptka admin can logout                                              0.01s  
  ✓ tpa admin can logout                                                 0.01s  

   PASS  Tests\Feature\SuperAdmin\SuperAdminFlowTest
  ✓ superadmin can login and redirected to superadmin dashboard          0.02s  
  ✓ superadmin can access dashboard                                      0.01s  
  ✓ superadmin cannot access lpptka routes                               0.01s  
  ✓ superadmin cannot access tpa routes                                  0.01s  
  ✓ superadmin can view unit approval list                               0.02s  
  ✓ superadmin can view unit approval details                            0.01s  
  ✓ superadmin can approve pending unit                                  0.01s  
  ✓ superadmin can reject pending unit                                   0.01s  
  ✓ superadmin cannot approve already approved unit                      0.02s  
  ✓ complete superadmin approval flow                                    0.03s  
  ✓ superadmin dashboard shows correct statistics                        0.02s  

   PASS  Tests\Feature\Tpa\TpaFlowTest
  ✓ tpa admin can login and redirected to tpa dashboard                  0.02s  
  ✓ tpa admin can access dashboard                                       0.02s  
  ✓ tpa admin cannot access superadmin routes                            0.01s  
  ✓ tpa admin cannot access lpptka routes                                0.01s  
  ✓ tpa admin can view santri list                                       0.02s  
  ✓ tpa admin can view create santri form                                0.01s  
  ✓ tpa admin can create new santri                                      0.02s  
  ✓ tpa admin can view santri detail                                     0.02s  
  ✓ tpa admin can edit santri                                            0.02s  
  ✓ tpa admin can update santri                                          0.02s  
  ✓ tpa admin can delete santri                                          0.02s  
  ✓ tpa admin can view unit profile                                      0.02s  
  ✓ tpa admin without unit sees no unit page                             0.01s  
  ✓ complete tpa santri management flow                                  0.05s  
  ✓ tpa dashboard shows correct statistics                               0.02s  
  ✓ tpa admin cannot access santri from other unit                       0.01s  
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:62

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:71

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.create] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:81

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:98

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:113

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.show] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:127

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.edit] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:140

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.update] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:160

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.destroy] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:177

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:193

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\ActivityControllerTes…  RouteNotFoundException   
  Route [admin.activities.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/ActivityControllerTest.php:205

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\AuthenticationTest > users can authenticate w…   
  The user is not authenticated
Failed asserting that false is true.

  at tests/Feature/Admin/AuthenticationTest.php:35
     31▕             'email' => 'test@example.com',
     32▕             'password' => 'password',
     33▕         ]);
     34▕ 
  ➜  35▕         $this->assertAuthenticated();
     36▕         $response->assertRedirect(route('admin.dashboard'));
     37▕     }
     38▕ 
     39▕     /** @test */

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\DashboardControllerTe…  RouteNotFoundException   
  Route [admin.dashboard] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/DashboardControllerTest.php:24

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\DashboardControllerTe…  RouteNotFoundException   
  Route [admin.dashboard] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/DashboardControllerTest.php:33

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\DashboardControllerTe…  RouteNotFoundException   
  Route [admin.dashboard] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/DashboardControllerTest.php:43

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:67

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:76

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.create] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:86

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:99

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:119

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:132

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.show] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:143

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.edit] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:156

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.update] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:173

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.destroy] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:191

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:208

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\SantriControllerTest…   RouteNotFoundException   
  Route [admin.santri.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/SantriControllerTest.php:219

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:60

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:69

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.create] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:79

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:94

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:120

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:154

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.show] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:165

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.edit] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:178

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.update] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:195

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.destroy] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:212

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:229

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UnitControllerTest >…   RouteNotFoundException   
  Route [admin.units.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UnitControllerTest.php:242

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user can login with valid cred…   
  The user is not authenticated
Failed asserting that false is true.

  at tests/Feature/Admin/UserFlowTest.php:104
    100▕             'password' => 'password123',
    101▕         ]);
    102▕ 
    103▕         // Step 3: Should be authenticated and redirected to dashboard
  ➜ 104▕         $this->assertAuthenticated();
    105▕         $response->assertRedirect(route('admin.dashboard'));
    106▕ 
    107▕         // Step 4: Visit dashboard should work
    108▕         $this->get(route('admin.dashboard'))->assertStatus(200);

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.santri.create] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:131

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.santri.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:186

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user s…  RouteNotFoundException   
  Route [admin.santri.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:214

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.santri.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:256

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.santri.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:272

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.santri.edit] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:309

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.units.create] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:364

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.units.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:425

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user s…  RouteNotFoundException   
  Route [admin.units.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:467

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.units.index] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:519

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.activities.store] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:556

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > user c…  RouteNotFoundException   
  Route [admin.activities.show] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Admin/UserFlowTest.php:592

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Admin\UserFlowTest > complete user journey login cr…   
  The user is not authenticated
Failed asserting that false is true.

  at tests/Feature/Admin/UserFlowTest.php:610
    606▕         $this->post(route('login'), [
    607▕             'email' => 'admin@bkprmi.test',
    608▕             'password' => 'password123',
    609▕         ]);
  ➜ 610▕         $this->assertAuthenticated();
    611▕ 
    612▕         // Step 2: Create Unit
    613▕         $unitResponse = $this->post(route('admin.units.store'), [
    614▕             'unit_number' => 'UNIT-JOURNEY-001',

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > guest cannot…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > member can a…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activities i…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activities c…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activities c…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activities c…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activities c…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activities a…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activities p…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > guest cannot…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > member can v…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activity sho…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activity sho…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activity sho…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > guest cannot…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > member can v…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activity log…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activity log…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activity log…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityControllerTest > activity log…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityControllerTest.php:37
     33▕ 
     34▕         $this->member = User::factory()->create();
     35▕         UserRole::factory()->create([
     36▕             'user_id' => $this->member->id,
  ➜  37▕             'role' => RoleType::MEMBER->value,
     38▕         ]);
     39▕ 
     40▕         $this->region = Region::factory()->create();
     41▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ActivityControllerTest.php:37

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityTest > guest cannot access ac…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityTest.php:29
     25▕ 
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕ 
     32▕         $region = Region::factory()->create();
     33▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ActivityTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityTest > member can view activi…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityTest.php:29
     25▕ 
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕ 
     32▕         $region = Region::factory()->create();
     33▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ActivityTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityTest > activities page displa…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityTest.php:29
     25▕ 
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕ 
     32▕         $region = Region::factory()->create();
     33▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ActivityTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityTest > activities can be filt…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityTest.php:29
     25▕ 
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕ 
     32▕         $region = Region::factory()->create();
     33▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ActivityTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityTest > member can view activi…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityTest.php:29
     25▕ 
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕ 
     32▕         $region = Region::factory()->create();
     33▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ActivityTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ActivityTest > activities are paginat…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ActivityTest.php:29
     25▕ 
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕ 
     32▕         $region = Region::factory()->create();
     33▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ActivityTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberAuthentication…  RouteNotFoundException   
  Route [member.dashboard] not defined.

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+2 vendor frames [22m
  3   tests/Feature/Member/MemberAuthenticationTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberAuthenticationTest > authentica…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberAuthenticationTest.php:39
     35▕     {
     36▕         $user = User::factory()->create();
     37▕         UserRole::factory()->create([
     38▕             'user_id' => $user->id,
  ➜  39▕             'role' => RoleType::MEMBER->value,
     40▕         ]);
     41▕ 
     42▕         $response = $this->actingAs($user)
     43▕             ->get(route('member.dashboard'));

  1   tests/Feature/Member/MemberAuthenticationTest.php:39

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberAuthenticationTest > inactive u…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberAuthenticationTest.php:55
     51▕         // Note: If you want to restrict inactive users, add middleware check
     52▕         $user = User::factory()->create(['is_active' => false]);
     53▕         UserRole::factory()->create([
     54▕             'user_id' => $user->id,
  ➜  55▕             'role' => RoleType::MEMBER->value,
     56▕         ]);
     57▕ 
     58▕         $response = $this->actingAs($user)
     59▕             ->get(route('member.dashboard'));

  1   tests/Feature/Member/MemberAuthenticationTest.php:55

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberAuthenticationTest > admin can…   Error   
  Undefined constant App\Enum\RoleType::ADMIN

  at tests/Feature/Member/MemberAuthenticationTest.php:72
     68▕     {
     69▕         $admin = User::factory()->create();
     70▕         UserRole::factory()->create([
     71▕             'user_id' => $admin->id,
  ➜  72▕             'role' => RoleType::ADMIN->value,
     73▕         ]);
     74▕ 
     75▕         $response = $this->actingAs($admin)
     76▕             ->get(route('member.dashboard'));

  1   tests/Feature/Member/MemberAuthenticationTest.php:72

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberAuthenticationTest > user can l…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberAuthenticationTest.php:87
     83▕     {
     84▕         $user = User::factory()->create();
     85▕         UserRole::factory()->create([
     86▕             'user_id' => $user->id,
  ➜  87▕             'role' => RoleType::MEMBER->value,
     88▕         ]);
     89▕ 
     90▕         $response = $this->actingAs($user)
     91▕             ->post(route('logout'));

  1   tests/Feature/Member/MemberAuthenticationTest.php:87

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberAuthenticationTest > login redi…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberAuthenticationTest.php:106
    102▕             'password' => 'password',
    103▕         ]);
    104▕         UserRole::factory()->create([
    105▕             'user_id' => $user->id,
  ➜ 106▕             'role' => RoleType::MEMBER->value,
    107▕         ]);
    108▕ 
    109▕         // First, try to access protected page as guest
    110▕         $this->get(route('member.activities.index'));

  1   tests/Feature/Member/MemberAuthenticationTest.php:106

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > guest…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > membe…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > admin…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > dashb…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > dashb…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > dashb…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > dashb…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > dashb…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > dashb…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardControllerTest > dashb…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardControllerTest.php:34
     30▕         // Create member user
     31▕         $this->member = User::factory()->create();
     32▕         UserRole::factory()->create([
     33▕             'user_id' => $this->member->id,
  ➜  34▕             'role' => RoleType::MEMBER->value,
     35▕         ]);
     36▕ 
     37▕         // Create admin user
     38▕         $this->admin = User::factory()->create();

  1   tests/Feature/Member/MemberDashboardControllerTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardTest > guest cannot ac…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardTest.php:29
     25▕         // Create a member user
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕     }
     32▕ 
     33▕     #[Test]

  1   tests/Feature/Member/MemberDashboardTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardTest > authenticated m…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardTest.php:29
     25▕         // Create a member user
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕     }
     32▕ 
     33▕     #[Test]

  1   tests/Feature/Member/MemberDashboardTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardTest > dashboard displ…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardTest.php:29
     25▕         // Create a member user
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕     }
     32▕ 
     33▕     #[Test]

  1   tests/Feature/Member/MemberDashboardTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardTest > dashboard displ…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardTest.php:29
     25▕         // Create a member user
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕     }
     32▕ 
     33▕     #[Test]

  1   tests/Feature/Member/MemberDashboardTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\MemberDashboardTest > dashboard has q…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/MemberDashboardTest.php:29
     25▕         // Create a member user
     26▕         $this->member = User::factory()->create();
     27▕         UserRole::factory()->create([
     28▕             'user_id' => $this->member->id,
  ➜  29▕             'role' => RoleType::MEMBER->value,
     30▕         ]);
     31▕     }
     32▕ 
     33▕     #[Test]

  1   tests/Feature/Member/MemberDashboardTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > guest ca…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > member c…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > guest ca…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > member c…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > unit det…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > unit det…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > unit det…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > unit det…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > guest ca…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > member c…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationControllerTest > organiza…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationControllerTest.php:32
     28▕ 
     29▕         $this->member = User::factory()->create();
     30▕         UserRole::factory()->create([
     31▕             'user_id' => $this->member->id,
  ➜  32▕             'role' => RoleType::MEMBER->value,
     33▕         ]);
     34▕ 
     35▕         $this->region = Region::factory()->create();
     36▕     }

  1   tests/Feature/Member/OrganizationControllerTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationTest > guest cannot acces…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationTest.php:27
     23▕ 
     24▕         $this->member = User::factory()->create();
     25▕         UserRole::factory()->create([
     26▕             'user_id' => $this->member->id,
  ➜  27▕             'role' => RoleType::MEMBER->value,
     28▕         ]);
     29▕     }
     30▕ 
     31▕     #[Test]

  1   tests/Feature/Member/OrganizationTest.php:27

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationTest > member can view or…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationTest.php:27
     23▕ 
     24▕         $this->member = User::factory()->create();
     25▕         UserRole::factory()->create([
     26▕             'user_id' => $this->member->id,
  ➜  27▕             'role' => RoleType::MEMBER->value,
     28▕         ]);
     29▕     }
     30▕ 
     31▕     #[Test]

  1   tests/Feature/Member/OrganizationTest.php:27

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationTest > organization page…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationTest.php:27
     23▕ 
     24▕         $this->member = User::factory()->create();
     25▕         UserRole::factory()->create([
     26▕             'user_id' => $this->member->id,
  ➜  27▕             'role' => RoleType::MEMBER->value,
     28▕         ]);
     29▕     }
     30▕ 
     31▕     #[Test]

  1   tests/Feature/Member/OrganizationTest.php:27

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationTest > organization page…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationTest.php:27
     23▕ 
     24▕         $this->member = User::factory()->create();
     25▕         UserRole::factory()->create([
     26▕             'user_id' => $this->member->id,
  ➜  27▕             'role' => RoleType::MEMBER->value,
     28▕         ]);
     29▕     }
     30▕ 
     31▕     #[Test]

  1   tests/Feature/Member/OrganizationTest.php:27

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationTest > organization page…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationTest.php:27
     23▕ 
     24▕         $this->member = User::factory()->create();
     25▕         UserRole::factory()->create([
     26▕             'user_id' => $this->member->id,
  ➜  27▕             'role' => RoleType::MEMBER->value,
     28▕         ]);
     29▕     }
     30▕ 
     31▕     #[Test]

  1   tests/Feature/Member/OrganizationTest.php:27

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationTest > member can view un…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationTest.php:27
     23▕ 
     24▕         $this->member = User::factory()->create();
     25▕         UserRole::factory()->create([
     26▕             'user_id' => $this->member->id,
  ➜  27▕             'role' => RoleType::MEMBER->value,
     28▕         ]);
     29▕     }
     30▕ 
     31▕     #[Test]

  1   tests/Feature/Member/OrganizationTest.php:27

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\OrganizationTest > member can view or…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/OrganizationTest.php:27
     23▕ 
     24▕         $this->member = User::factory()->create();
     25▕         UserRole::factory()->create([
     26▕             'user_id' => $this->member->id,
  ➜  27▕             'role' => RoleType::MEMBER->value,
     28▕         ]);
     29▕     }
     30▕ 
     31▕     #[Test]

  1   tests/Feature/Member/OrganizationTest.php:27

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > guest cannot a…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > member can acc…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > reports index…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > guest cannot d…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download santr…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download santr…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download santr…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download santr…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download santr…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > guest cannot d…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download activ…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download activ…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download activ…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download activ…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download activ…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download activ…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > guest cannot d…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download unit…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download unit…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download unit…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download unit…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > download unit…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > guest cannot a…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > print report r…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > print report v…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > print santri r…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > print activity…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > print unit rep…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > print santri r…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > print activity…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > print activity…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportControllerTest > print unit rep…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportControllerTest.php:38
     34▕ 
     35▕         $this->member = User::factory()->create();
     36▕         UserRole::factory()->create([
     37▕             'user_id' => $this->member->id,
  ➜  38▕             'role' => RoleType::MEMBER->value,
     39▕         ]);
     40▕ 
     41▕         $this->region = Region::factory()->create();
     42▕         $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);

  1   tests/Feature/Member/ReportControllerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportTest > guest cannot access repo…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportTest.php:28
     24▕ 
     25▕         $this->member = User::factory()->create();
     26▕         UserRole::factory()->create([
     27▕             'user_id' => $this->member->id,
  ➜  28▕             'role' => RoleType::MEMBER->value,
     29▕         ]);
     30▕ 
     31▕         $region = Region::factory()->create();
     32▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ReportTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportTest > member can view reports…   Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportTest.php:28
     24▕ 
     25▕         $this->member = User::factory()->create();
     26▕         UserRole::factory()->create([
     27▕             'user_id' => $this->member->id,
  ➜  28▕             'role' => RoleType::MEMBER->value,
     29▕         ]);
     30▕ 
     31▕         $region = Region::factory()->create();
     32▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ReportTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportTest > reports page shows avail…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportTest.php:28
     24▕ 
     25▕         $this->member = User::factory()->create();
     26▕         UserRole::factory()->create([
     27▕             'user_id' => $this->member->id,
  ➜  28▕             'role' => RoleType::MEMBER->value,
     29▕         ]);
     30▕ 
     31▕         $region = Region::factory()->create();
     32▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ReportTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportTest > download santri report r…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportTest.php:28
     24▕ 
     25▕         $this->member = User::factory()->create();
     26▕         UserRole::factory()->create([
     27▕             'user_id' => $this->member->id,
  ➜  28▕             'role' => RoleType::MEMBER->value,
     29▕         ]);
     30▕ 
     31▕         $region = Region::factory()->create();
     32▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ReportTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportTest > download activity report…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportTest.php:28
     24▕ 
     25▕         $this->member = User::factory()->create();
     26▕         UserRole::factory()->create([
     27▕             'user_id' => $this->member->id,
  ➜  28▕             'role' => RoleType::MEMBER->value,
     29▕         ]);
     30▕ 
     31▕         $region = Region::factory()->create();
     32▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ReportTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportTest > download unit report req…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportTest.php:28
     24▕ 
     25▕         $this->member = User::factory()->create();
     26▕         UserRole::factory()->create([
     27▕             'user_id' => $this->member->id,
  ➜  28▕             'role' => RoleType::MEMBER->value,
     29▕         ]);
     30▕ 
     31▕         $region = Region::factory()->create();
     32▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ReportTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\Member\ReportTest > print report requires au…  Error   
  Undefined constant App\Enum\RoleType::MEMBER

  at tests/Feature/Member/ReportTest.php:28
     24▕ 
     25▕         $this->member = User::factory()->create();
     26▕         UserRole::factory()->create([
     27▕             'user_id' => $this->member->id,
  ➜  28▕             'role' => RoleType::MEMBER->value,
     29▕         ]);
     30▕ 
     31▕         $region = Region::factory()->create();
     32▕         $this->unit = Unit::factory()->create(['region_id' => $region->id]);

  1   tests/Feature/Member/ReportTest.php:28


  Tests:    166 failed, 95 passed (278 assertions)
  Duration: 3.92s

