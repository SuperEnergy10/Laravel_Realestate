<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Agent\AgentPropertyController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\ChatController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\BlogCategory;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// User Frontend All Route

Route::get('/', [UserController::class, 'index']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');


    // schedule request
    Route::get('/user/schedule/request', [UserController::class, 'UserScheduleRequest'])->name('user.schedule.request');
    // live chat
    Route::get('/live/chat', [UserController::class, 'LiveChat'])->name('live.chat');
    //about us
    Route::get('/about', [UserController::class, 'About'])->name('about');
    Route::get('/contact', [UserController::class, 'Contact'])->name('contact');

});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
});

Route::middleware(['auth', 'roles:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
    Route::get('/agent/logout', [AgentController::class, 'AgentLogout'])->name('agent.logout');
    Route::get('/agent/profile', [AgentController::class, 'AgentProfile'])->name('agent.profile');
    Route::get('/agent/profile', [AgentController::class, 'AgentProfile'])->name('agent.profile');
    Route::post('/agent/profile/store', [AgentController::class, 'AgentProfileStore'])->name('agent.profile.store');
    Route::get('/agent/change/password', [AgentController::class, 'AgentChangePassword'])->name('agent.change.password');
    Route::post('/agent/update/password', [AgentController::class, 'AgentUpdatePassword'])->name('agent.update.password');
});

Route::get('/agent/login', [AgentController::class, 'AgentLogin'])->name('agent.login')->middleware(RedirectIfAuthenticated::class);
Route::post('/agent/register', [AgentController::class, 'AgentRegister'])->name('agent.register');

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);

Route::middleware(['auth', 'roles:admin'])->group(function () {
    // PropertyType Route

    Route::controller(PropertyTypeController::class)->group(function () {
        Route::get('/all/type', 'AllType')->name('all.type');
        Route::get('/add/type', 'AddType')->name('add.type')->middleware('permission:add.type');
        Route::post('/store/type', 'StoreType')->name('store.type')->middleware('permission:store.type');
        Route::get('/edit/type/{id}', 'EditType')->name('edit.type')->middleware('permission:edit.type');
        Route::post('/update/type', 'UpdateType')->name('update.type')->middleware('permission:update.type');
        Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type')->middleware('permission:delete.type');
    });
    // Amenitie Route
    Route::controller(PropertyTypeController::class)->group(function () {
        Route::get('/all/amenitie', 'AllAmenitie')->name('all.amenitie');
        Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie')->middleware('permission:amenitie.add');
        Route::post('/store/amenitie', 'StoreAmenitie')->name('store.amenitie');
        Route::get('/edit/amenitie/{id}', 'EditAmenitie')->name('edit.amenitie')->middleware('permission:amenitie.edit');
        Route::post('/update/amenitie', 'UpdateAmenitie')->name('update.amenitie');
        Route::get('/delete/amenitie/{id}', 'DeleteAmenitie')->name('delete.amenitie')->middleware('permission:amenitie.delete');
    });

    // Property Route
    Route::controller(PropertyController::class)->group(function () {
        Route::get('/all/property', 'AllProperty')->name('all.property')->middleware('permission:property.all');
        Route::get('/add/property', 'AddProperty')->name('add.property')->middleware('permission:property.add');
        Route::post('/store/property', 'StoreProperty')->name('store.property');
        Route::get('/edit/property/{id}', 'EditProperty')->name('edit.property')->middleware('permission:property.edit');
        Route::post('/update/property', 'UpdateProperty')->name('update.property');
        Route::post('/update/property/thumbnail', 'UpdatePropertyThumbnail')->name('update.property.thumbnail');
        Route::post('/update/property/multiimage', 'UpdatePropertyMultiimage')->name('update.property.multiimage');
        Route::get('/delete/property/multiimage/{id}', 'DeletePropertyMultiimage')->name('delete.property.multiimage')->middleware('permission:property.delete');
        Route::get('/delete/property/{id}', 'DeleteProperty')->name('delete.property')->middleware('permission:property.delete');
        Route::post('/store/new/multiimage', 'StoreNewMultiimage')->name('store.new.multiimage');
        Route::post('/update/property/facilities', 'UpdatePropertyFacilities')->name('update.property.facilities');
        Route::get('/details/property/{id}', 'DetailsProperty')->name('details.property');
        Route::post('/inactive/property', 'InactiveProperty')->name('inactive.property');
        Route::post('/active/property', 'ActiveProperty')->name('active.property');

        Route::get('admin/package/history', 'AdminPackageHistory')->name('admin.package.history');
        Route::get('admin/package/invoice/{id}', 'AdminPackageInvoice')->name('admin.package.invoice');

        Route::get('admin/property/message', 'AdminPropertyMessage')->name('admin.property.message');
    });

    // All Agent Route

    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/agent', 'AllAgent')->name('all.agent');
        Route::get('/add/agent', 'AddAgent')->name('add.agent')->middleware('permission:agent.add');
        Route::post('/store/agent', 'StoreAgent')->name('store.agent');
        Route::get('/edit/agent/{id}', 'EditAgent')->name('edit.agent')->middleware('permission:agent.edit');
        Route::post('/update/agent', 'UpdateAgent')->name('update.agent');
        Route::get('/delete/agent/{id}', 'DeleteAgent')->name('delete.agent')->middleware('permission:agent.delete');


        Route::get('/changeStatus', 'changeStatus');
    });

    // Agent All Property


    // admin all state

    Route::controller(StateController::class)->group(function () {
        Route::get('/all/state', 'AllState')->name('all.state');
        Route::get('/add/state', 'AddState')->name('add.state')->middleware('permission:state.add');
        Route::post('/store/state', 'StoreState')->name('store.state');
        Route::get('/edit/state/{id}', 'EditState')->name('edit.state')->middleware('permission:state.edit');
        Route::post('/update/state', 'UpdateState')->name('update.state');
        Route::get('/delete/state/{id}', 'DeleteState')->name('delete.state')->middleware('permission:state.delete');
    });

    // route testimonials

    Route::controller(TestimonialController::class)->group(function () {
        Route::get('/all/testimonials', 'AllTestimonials')->name('all.testimonials');
        Route::get('/add/testimonials', 'AddTestimonials')->name('add.testimonials')->middleware('permission:testimonials.add');
        Route::post('/store/testimonials', 'StoreTestimonials')->name('store.testimonials');
        Route::get('/edit/testimonials/{id}', 'EditTestimonials')->name('edit.testimonials')->middleware('permission:testimonials.edit');
        Route::post('/update/testimonials', 'UpdateTestimonials')->name('update.testimonials');
        Route::get('/delete/testimonials/{id}', 'DeleteTestimonials')->name('delete.testimonials')->middleware('permission:testimonials.delete');
    });

    //Blog Category 

    Route::controller(BlogController::class)->group(function () {
        Route::get('/all/blog/category', 'AllBlogCategory')->name('all.blog.category');
        Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category');
        Route::get('/edit/blog/category/{id}', 'EditBlogCategory')->middleware('permission:category.edit');
        Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
        Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category')->middleware('permission:category.delete');
    });

    // route blog post

    Route::controller(BlogController::class)->group(function () {
        Route::get('/all/blog/post', 'AllBlogPost')->name('all.blog.post');
        Route::get('/add/blog/post', 'AddBlogPost')->name('add.blog.post')->middleware('permission:post.add');
        Route::post('/store/blog/post', 'StoreBlogPost')->name('store.blog.post');
        Route::get('/edit/blog/post/{id}', 'EditBlogPost')->name('edit.blog.post')->middleware('permission:post.edit');
        Route::post('/update/blog/post', 'UpdateBlogPost')->name('update.blog.post');
        Route::get('/delete/blog/post/{id}', 'DeleteBlogPost')->name('delete.blog.post')->middleware('permission:post.delete');
    });

    // SMTP Setting Route

    Route::controller(SettingController::class)->group(function () {
        Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
        Route::post('/update/smtp/setting', 'UpdateSmtpSetting')->name('update.smtp.setting');
    });


    // site setting route

    Route::controller(SettingController::class)->group(function () {
        Route::get('/site/setting', 'SiteSetting')->name('site.setting');
        Route::post('/update/site/setting', 'UpdateSiteSetting')->name('update.site.setting');
    });

    // permission route

    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/permission', 'AllPermission')->name('all.permission')->middleware('permission:role.all');
        Route::get('/add/permission', 'AddPermission')->name('add.permission')->middleware('permission:role.add');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission')->middleware('permission:role.edit');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission')->middleware('permission:role.delete');


        Route::get('/import/permission', 'ImportPermission')->name('import.permission');
        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');
    });


// role route

    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/roles', 'AllRoles')->name('all.roles')->middleware('permission:role.all');
        Route::get('/add/roles', 'AddRoles')->name('add.roles')->middleware('permission:role.add');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles')->middleware('permission:role.edit');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles')->middleware('permission:role.delete');

//role has permission route
        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission')->middleware('permission:role.add');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission')->middleware('permission:role.all');
        Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
        Route::get('/edit/roles/permission/{id}', 'EditRolesPermission')->name('edit.roles.permission')->middleware('permission:role.edit');
        Route::post('/update/role/permission/{id}', 'UpdateRolePermission')->name('update.role.permission');
        Route::get('/delete/role/permission/{id}', 'DeleteRolePermission')->name('delete.role.permission')->middleware('permission:role.delete');


    });


    // all admin user route
    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/admin', 'AllAdmin')->name('all.admin')->middleware('permission:role.all');
        Route::get('/add/admin', 'AddAdmin')->name('add.admin')->middleware('permission:role.add');
        Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin')->middleware('permission:role.edit');
        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin')->middleware('permission:role.delete');

    });

});

Route::middleware(['auth', 'roles:agent'])->group(function () {
    Route::controller(AgentPropertyController::class)->group(function () {
        Route::get('/agent/all/property', 'AgentAllProperty')->name('agent.all.property');
        Route::get('/agent/add/property', 'AgentAddProperty')->name('agent.add.property');
        Route::post('/agent/store/property', 'AgentStoreProperty')->name('agent.store.property');
        Route::get('/agent/edit/property/{id}', 'AgentEditProperty')->name('agent.edit.property');
        Route::post('/agent/update/property', 'AgentUpdateProperty')->name('agent.update.property');
        Route::post('/agent/update/property/thumbnail', 'AgentUpdatePropertyThumbnail')->name('agent.update.property.thumbnail');
        Route::post('/agent/update/property/multiimage', 'AgentUpdatePropertyMultiimage')->name('agent.update.property.multiimage');
        Route::get('/agent/delete/property/multiimage/{id}', 'AgentDeletePropertyMultiimage')->name('agent.delete.property.multiimage');
        Route::post('/agent/store/new/multiimage', 'AgentStoreNewMultiimage')->name('agent.store.new.multiimage');
        Route::post('/agent/update/property/facilities', 'AgentUpdatePropertyFacilities')->name('agent.update.property.facilities');
        Route::get('/agent/details/property/{id}', 'AgentDetailsProperty')->name('agent.details.property');
        Route::get('/agent/delete/property/{id}', 'AgentDeleteProperty')->name('agent.delete.property');

        Route::get('/agent/property/message', 'AgentPropertyMessage')->name('agent.property.message');
        Route::get('/agent/message/details/{id}', 'AgentMessageDetails')->name('agent.message.details');

        // schedule request route

        Route::get('/agent/schedule/request', 'AgentScheduleRequest')->name('agent.schedule.request');
        Route::get('/agent/details/schedule/{id}', 'AgentDetailsSchedule')->name('agent.details.schedule');
        Route::post('/agent/update/schedule', 'AgentUpdateSchedule')->name('agent.update.schedule');
    });


    // Buy Package Route
    Route::controller(AgentPropertyController::class)->group(function () {
        Route::get('/buy/package', 'BuyPackage')->name('buy.package');
        Route::get('/buy/business/plan', 'BuyBusinessPlan')->name('buy.business.plan');
        Route::post('/store/business/plan', 'StoreBusinessPlan')->name('store.business.plan');
        Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
        Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');
        Route::get('/package/history', 'PackageHistory')->name('package.history');
        Route::get('/agent/package/invoice/{id}', 'AgentPackageInvoice')->name('agent.package.invoice');
    });
});

// frontend properties detaild all route

Route::get('/property/details/{id}/{slug}', [IndexController::class, 'PropertyDetails'])
    ->name('property.details');

Route::post('/add-to-wishlist/{property_id}', [WishlistController::class, 'AddToWishList']);
Route::post('/add-to-compare/{property_id}', [CompareController::class, 'AddToCompare']);
Route::post('/property/message', [IndexController::class, 'PropertyMessage'])->name('property.message');
Route::get('/agent/details/{id}', [IndexController::class, 'AgentDetails'])->name('agent.details');
Route::post('/agent/details/message', [IndexController::class, 'AgentDetailsMessage'])->name('agent.details.message');

// for rent and buy
Route::get('/property', [IndexController::class, 'Property'])->name('property');

Route::get('/rent/property', [IndexController::class, 'RentProperty'])->name('rent.property');
Route::get('/buy/property', [IndexController::class, 'BuyProperty'])->name('buy.property');
Route::get('/property/type/{id}', [IndexController::class, 'PropertyType'])->name('property.type');

// route state details data
Route::get('/state/details/{id}', [IndexController::class, 'StateDetails'])->name('state.details');


// HomePage Buy and Rent Search 
Route::post('/buy/property/search', [IndexController::class, 'BuyPropertySearch'])->name('buy.property.search');
Route::post('/rent/property/search', [IndexController::class, 'RentPropertySearch'])->name('rent.property.search');
Route::post('/all/property/search', [IndexController::class, 'AllPropertySearch'])->name('all.property.search');
Route::post('/store/schedule', [IndexController::class, 'StoreSchedule'])->name('store.schedule');

// live chat 
Route::post('/send-message', [ChatController::class, 'SendMsg'])->name('send.msg');
Route::get('/all-user', [ChatController::class, 'GetAllUser']);
Route::get('/user-message/{id}', [ChatController::class, 'UserMsgById']);
Route::get('/agent/live/chat', [ChatController::class, 'AgentLiveChat'])->name('agent.live.chat');


Route::controller(WishlistController::class)->group(function () {
    Route::get('/user/wishlist', 'UserWishList')->name('user.wishlist');
    Route::get('/get-wishlist-property', 'GetWishListProperty')->name('get.wishlist.property');
    Route::get('/wishlist-remove/{id}', 'WishListRemove')->name('wishlist.remove');
});

Route::controller(CompareController::class)->group(function () {
    Route::get('/user/compare', 'UserCompare')->name('user.compare');
    Route::get('/get-compare-property', 'GetCompareProperty')->name('get.compare.property');
    Route::get('/compare-remove/{id}', 'CompareRemove')->name('compare.remove');
});

// blog details

Route::get('/blog/details/{slug}', [BlogController::class, 'BlogDetails'])->name('blog.details');
Route::get('/blog/cat/list/{id}', [BlogController::class, 'BlogCatList'])->name('blog.cat.list');
Route::get('/blog', [BlogController::class, 'BlogList'])->name('blog.list');
Route::post('/store/comment', [BlogController::class, 'StoreComment'])->name('store.comment');
Route::post('/reply/comment', [BlogController::class, 'ReplyComment'])->name('reply.comment');
Route::get('/admin/blog/comment', [BlogController::class, 'AdminBlogComment'])->name('admin.blog.comment');
Route::get('/admin/comment/reply/{id}', [BlogController::class, 'AdminCommentReply'])->name('admin.comment.reply');
