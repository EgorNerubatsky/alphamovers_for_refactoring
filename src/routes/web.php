<?php
// use BeyondCode\Mailbox\Facades\Mailbox;
// use BeyondCode\Mailbox\Routing\Route;


use App\Http\Controllers\ArticleController;
use App\Http\Controllers\IntervieweeController;
use App\Http\Controllers\PhpImapController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserTaskController;
use App\Models\BankOperation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientBaseController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\BankOperationController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\MoverController;
use App\Http\Controllers\ArrearController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\ChatsActivityController;
use App\Models\Chat;
use App\Providers\AppServiceProvider;


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

Route::get('/', function () {
    return view('welcome');
});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::prefix('ERP')->middleware(['auth', 'admin-panel'])->group(function(){
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

//     Route::prefix('users')->group(function(){
//         Route::get('/',[UserController::class, 'index'])->name('admin.users.index');
//         Route::get('edit/{user}', [UserController::class, 'edit'])->name('admin.users.edit');
//         Route::put('edit/{user}', [UserController::class, 'update'])->name('admin.users.update');
//         Route::get('delete/{user}', [UserController::class, 'delete'])->name('admin.users.delete');
//     });
// });

Route::prefix('ERP')->middleware(['auth', 'admin-panel'])->group(function () {

    Route::middleware(['admin'])->prefix('admin')->group(function () {


        Route::get('/employees', [EmployeeController::class, 'index'])->name('erp.admin.employees.index');
        Route::get('/employees/search', [EmployeeController::class, 'search'])->name('erp.admin.employees.search');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('erp.admin.employees.create');
        Route::post('/employees/store', [EmployeeController::class, 'store'])->name('erp.admin.employees.store');
        Route::get('/employees/delete/{id}', [EmployeeController::class, 'delete'])->name('erp.admin.employees.delete');
        Route::get('/employees/edit/{id}', [EmployeeController::class, 'edit'])->name('erp.admin.employees.edit');
        Route::put('/employees/update/{id}', [EmployeeController::class, 'adminUpdate'])->name('erp.admin.employees.adminUpdate');

//        Route::get('/', [AdminController::class, 'index'])->name('erp.admin.users.index');
        Route::get('/users', [UserController::class, 'index'])->name('erp.admin.users.index');
        Route::get('edit/{user}', [UserController::class, 'edit'])->name('erp.admin.users.edit');
        Route::put('edit/{user}', [UserController::class, 'update'])->name('erp.admin.users.update');
        Route::get('delete/{user}', [UserController::class, 'delete'])->name('erp.admin.users.delete');

        Route::get('/messages', [ChatsActivityController::class, 'index'])->name('erp.admin.messages.index');
        Route::post('/messages/storeChat', [ChatsActivityController::class, 'storeChat'])->name('erp.admin.messages.storeChat');
        Route::post('/messages/storeMessage', [ChatsActivityController::class, 'storeMessage'])->name('erp.admin.messages.storeMessage');
        Route::put('/messages/updateMessage/{id}', [ChatsActivityController::class, 'updateMessage'])->name('erp.admin.messages.updateMessage');
        Route::put('/messages/updateChatMessage/{id}', [ChatsActivityController::class, 'updateChatMessage'])->name('erp.admin.messages.updateChatMessage');
//        Route::post('/messages/storePrivatMessage', [ChatsActivityController::class, 'storePrivatMessage'])->name('erp.admin.messages.storePrivatMessage');
        Route::get('/messages/showChat/{id}', [ChatsActivityController::class, 'showChat'])->name('erp.admin.messages.showChat');
        Route::get('/messages/showPrivatChat/{id}', [ChatsActivityController::class, 'showPrivatChat'])->name('erp.admin.messages.showPrivatChat');
        Route::post('/messages/storeChatMessage/{id}',[ChatsActivityController::class,'storeChatMessage'])->name('erp.admin.messages.storeChatMessage');
        Route::post('/messages/addUser/{id}', [ChatsActivityController::class, 'addUser'])->name('erp.admin.messages.addUser');
        Route::get('/messages/deleteChat/{id}', [ChatsActivityController::class, 'deleteChat'])->name('erp.admin.messages.deleteChat');
        Route::put('/messages/updateChat/{id}', [ChatsActivityController::class, 'updateChat'])->name('erp.admin.messages.updateChat');
        Route::get('/messages/searchUsers', [ChatsActivityController::class, 'searchUsers'])->name('erp.admin.messages.searchUsers');
        Route::get('/messages/search', [ChatsActivityController::class, 'search'])->name('erp.admin.messages.search');
        Route::post('/messages/messageReply/{id}', [ChatsActivityController::class, 'messageReply'])->name('erp.admin.messages.messageReply');
        Route::post('/messages/chatReply/{id}', [ChatsActivityController::class, 'chatReply'])->name('erp.admin.messages.chatReply');
        Route::get('/messages/deleteMessage/{id}',[ChatsActivityController::class, 'deleteMessage'])->name('erp.admin.messages.deleteMessage');
        Route::get('/messages/deleteChatMessage/{id}',[ChatsActivityController::class, 'deleteChatMessage'])->name('erp.admin.messages.deleteChatMessage');
        Route::get('/messages/readMessage/{id}', [ChatsActivityController::class, 'readMessage'])->name('erp.admin.messages.readMessage');
//        Route::get('/messages/update-notifications', [ChatsActivityController::class, 'updateNotifications'])->name('erp.admin.messages.updateNotifications');

        Route::get('/articles', [ArticleController::class, 'index'])->name('erp.admin.articles.index');
        Route::post('/articles/storeArticle', [ArticleController::class, 'storeArticle'])->name('erp.admin.articles.storeArticle');
        Route::get('/articles/showArticle/{id}', [ArticleController::class, 'showArticle'])->name('erp.admin.articles.showArticle');
        Route::put('/articles/addToFavorites/{id}', [ArticleController::class, 'addToFavorites'])->name('erp.admin.articles.addToFavorites');
        Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->name('erp.admin.articles.edit');
        Route::put('/articles/update/{id}', [ArticleController::class, 'updateArticle'])->name('erp.admin.articles.updateArticle');
        Route::get('/messages/deleteFile/{id}',[ArticleController::class, 'deleteFile'])->name('erp.admin.articles.deleteFile');
        Route::get('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('erp.admin.articles.delete');
        Route::get('/articles/search', [ArticleController::class, 'search'])->name('erp.admin.articles.search');


    });

    Route::middleware(['manager'])->prefix('manager')->group(function () {

        Route::get('/leads', [LeadController::class, 'index'])->name('erp.manager.leads.index');
        Route::get('/leads/search', [LeadController::class, 'search'])->name('erp.manager.leads.search');
        Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('erp.manager.leads.update');
        Route::put('/leads', [LeadController::class, 'index'])->name('erp.manager.leads.toOrder');
//        Route::get('/leads/delete/{lead}', [LeadController::class, 'delete'])->name('erp.manager.leads.delete');
        Route::get('/leads/destroy/{lead}', [LeadController::class, 'destroy'])->name('erp.manager.leads.destroy');
        Route::post('/leads/store',[LeadController::class, 'store'])->name('erp.manager.leads.store');
        Route::get('/leads/deleteFile/{id}', [LeadController::class, 'deleteFile'])->name('erp.manager.leads.deleteFile');


        Route::get('/orders', [OrderController::class, 'index'])->name('erp.manager.orders.index');
        Route::get('/orders/priceSort', [OrderController::class, 'sortByPriceTab'])->name('erp.manager.orders.sortByPriceTab');
        Route::get('/orders/dateSort', [OrderController::class, 'sortByDateTab'])->name('erp.manager.orders.sortByDateTab');
        Route::get('/orders/sortByDescription', [OrderController::class, 'sortByDescription'])->name('erp.manager.orders.sortByDescription');
        Route::get('/orders/sortByCompany', [OrderController::class, 'sortByCompany'])->name('erp.manager.orders.sortByCompany');
        Route::get('/orders/search', [OrderController::class, 'search'])->name('erp.manager.orders.search');
        Route::get('/orders/edit/{order}', [OrderController::class, 'edit'])->name('erp.manager.orders.edit');
        Route::put('/orders/edit/{order}', [OrderController::class, 'update'])->name('erp.manager.orders.update');
        Route::put('/toBankOperations/{id}', [OrderController::class, 'toBankOperations'])->name('erp.manager.orders.toBankOperations');
        Route::get('/orders/{id}', [OrderController::class, 'takeAtWork'])->name('erp.manager.orders.takeAtWork');
        Route::get('/orders/new/create', [OrderController::class, 'create'])->name('erp.manager.orders.create');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('erp.manager.orders.store');
        Route::get('/orders/delete/{order}', [OrderController::class, 'destroy'])->name('erp.manager.orders.delete');
        Route::get('/orders/cancellation/{order}', [OrderController::class, 'cancellation'])->name('erp.manager.orders.cancellation');
        Route::get('/orders/return/{order}', [OrderController::class, 'return'])->name('erp.manager.orders.return');
        Route::post('/orders/edit/{id}', [OrderController::class, 'addFiles'])->name('erp.manager.orders.addFiles');
        Route::delete('/orders/edit/{id}', [OrderController::class, 'deleteFile'])->name('erp.manager.orders.deleteFile');
        Route::post('/orders/edit/addComment/{id}', [OrderController::class, 'addComment'])->name('erp.manager.orders.addComment');

        Route::get('/clients', [ClientBaseController::class, 'index'])->name('erp.manager.clients.index');
        Route::get('/clients/search', [ClientBaseController::class, 'search'])->name('erp.manager.clients.search');
        Route::get('/clients/create', [ClientBaseController::class, 'create'])->name('erp.manager.clients.create');
        // Route::get('/clients/contactCreate', [ClientBaseController::class, 'contactCreate'])->name('erp.manager.clients.contactCreate');
        Route::post('/clients/store', [ClientBaseController::class, 'store'])->name('erp.manager.clients.store');
        // Route::get('/clients/edit/{clientBase}', [ClientBaseController::class, 'edit'])->name('erp.manager.clients.edit');
        Route::get('/clients/edit/{clientBase}', [ClientBaseController::class, 'edit'])->name('erp.manager.clients.edit');
        Route::put('/clients/edit/{clientBase}', [ClientBaseController::class, 'update'])->name('erp.manager.clients.update');
        Route::get('/clients/delete/{clientBase}', [ClientBaseController::class, 'destroy'])->name('erp.manager.clients.delete');
        Route::post('/clients/edit/{id}', [ClientBaseController::class, 'addFiles'])->name('erp.manager.clients.addFiles');
        Route::delete('/clients/edit/{id}', [ClientBaseController::class, 'deleteFile'])->name('erp.manager.clients.deleteFile');
        Route::get('/clients/{id}', [ClientBaseController::class, 'clientContactDelete'])->name('erp.manager.clients.client_delete');
        Route::post('/clients/edit/addComment/{id}', [ClientBaseController::class, 'addComment'])->name('erp.manager.clients.addComment');

        Route::get('/finances', [BankOperationController::class, 'index'])->name('erp.manager.finances.index');
        Route::get('/finances/search', [BankOperationController::class, 'search'])->name('erp.manager.finances.search');
        Route::get('/report', [FinanceController::class, 'index'])->name('erp.manager.report');


        Route::get('/tasks', [UserTaskController::class, 'index'])->name('erp.manager.tasks.index');
        Route::post('/tasks/store', [UserTaskController::class, 'store'])->name('erp.manager.tasks.store');
        Route::get('/tasks/search',[UserTaskController::class,'search'])->name('erp.manager.tasks.search');
        Route::post('/tasks/remove', [UserTaskController::class, 'remove'])->name('erp.manager.tasks.remove');
        Route::post('/tasks/update', [UserTaskController::class, 'update'])->name('erp.manager.tasks.update');
        Route::post('/task/updateTaskColumn', [UserTaskController::class, 'updateTaskColumn'])->name('erp.manager.tasks.updateTaskColumn');
        Route::post('/task/storeKanban', [UserTaskController::class, 'storeKanban'])->name('erp.manager.tasks.storeKanban');
        Route::put('/task/updateKanban', [UserTaskController::class, 'updateKanban'])->name('erp.manager.tasks.updateKanban');
        Route::put('/task/updateKanbanTask', [UserTaskController::class, 'updateKanbanTask'])->name('erp.manager.tasks.updateKanbanTask');
        Route::get('/task/deleteKanban/{id}', [UserTaskController::class, 'deleteKanban'])->name('erp.manager.tasks.deleteKanban');
        Route::get('/task/deleteKanbanTask/{id}', [UserTaskController::class, 'deleteKanbanTask'])->name('erp.manager.tasks.deleteKanbanTask');
        Route::post('/task/storeKanbanTask', [UserTaskController::class, 'storeKanbanTask'])->name('erp.manager.tasks.storeKanbanTask');
        Route::get('/tasks/taskView/{id}', [UserTaskController::class, 'taskView'])->name('erp.manager.tasks.taskView');


        Route::get('/mail', [MailController::class, 'index'])->name('erp.manager.emails.index');
        Route::get('/mail/sendemails', [MailController::class, 'sendEmails'])->name('erp.manager.emails.sendEmails');
        Route::get('/mail/newemail', [MailController::class, 'newMail'])->name('erp.manager.emails.newMail');
        Route::post('/mail/sendemail', [MailController::class, 'sendMail'])->name('erp.manager.emails.sendMail');
        Route::get('/mail/getemails', [MailController::class,'getMails'])->name('erp.manager.emails.getMails');
        Route::get('/mail/openemail/{id}', [MailController::class, 'openEmail'])->name('erp.manager.emails.openEmail');
        Route::get('/mail/opensendemail/{id}', [MailController::class, 'openSendEmail'])->name('erp.manager.emails.openSendEmail');
        Route::put('/mail/deleteemail/', [MailController::class, 'deleteEmail'])->name('erp.manager.emails.deleteEmail');
        Route::put('/mail/forcedeleteemail', [MailController::class, 'forceDeleteEmails'])->name('erp.manager.emails.forceDeleteEmails');
        Route::get('/mail/deletedemails', [MailController::class, 'deletedEmails'])->name('erp.manager.emails.deletedEmails');
        Route::get('/mail/restoreemail/{id}', [MailController::class, 'restoreEmail'])->name('erp.manager.emails.restoreEmail');
        Route::get('/mail/search', [MailController::class, 'search'])->name('erp.manager.emails.search');
        Route::get('/mail/sendsSearch', [MailController::class,'sendsSearch'])->name('erp.manager.emails.sendEmailsSearch');


        Route::get('/messages', [ChatsActivityController::class, 'index'])->name('erp.manager.messages.index');
        Route::post('/messages/storeChat', [ChatsActivityController::class, 'storeChat'])->name('erp.manager.messages.storeChat');
        Route::post('/messages/storeMessage', [ChatsActivityController::class, 'storeMessage'])->name('erp.manager.messages.storeMessage');
        Route::put('/messages/updateMessage/{id}', [ChatsActivityController::class, 'updateMessage'])->name('erp.manager.messages.updateMessage');
        Route::put('/messages/updateChatMessage/{id}', [ChatsActivityController::class, 'updateChatMessage'])->name('erp.manager.messages.updateChatMessage');
//        Route::post('/messages/storePrivatMessage', [ChatsActivityController::class, 'storePrivatMessage'])->name('erp.manager.messages.storePrivatMessage');
        Route::get('/messages/showChat/{id}', [ChatsActivityController::class, 'showChat'])->name('erp.manager.messages.showChat');
        Route::get('/messages/showPrivatChat/{id}', [ChatsActivityController::class, 'showPrivatChat'])->name('erp.manager.messages.showPrivatChat');
        Route::post('/messages/storeChatMessage/{id}',[ChatsActivityController::class,'storeChatMessage'])->name('erp.manager.messages.storeChatMessage');
        Route::post('/messages/addUser/{id}', [ChatsActivityController::class, 'addUser'])->name('erp.manager.messages.addUser');
        Route::get('/messages/deleteChat/{id}', [ChatsActivityController::class, 'deleteChat'])->name('erp.manager.messages.deleteChat');
        Route::put('/messages/updateChat/{id}', [ChatsActivityController::class, 'updateChat'])->name('erp.manager.messages.updateChat');
        Route::get('/messages/searchUsers', [ChatsActivityController::class, 'searchUsers'])->name('erp.manager.messages.searchUsers');
        Route::get('/messages/search', [ChatsActivityController::class, 'search'])->name('erp.manager.messages.search');
        Route::post('/messages/messageReply/{id}', [ChatsActivityController::class, 'messageReply'])->name('erp.manager.messages.messageReply');
        Route::post('/messages/chatReply/{id}', [ChatsActivityController::class, 'chatReply'])->name('erp.manager.messages.chatReply');
        Route::get('/messages/deleteMessage/{id}',[ChatsActivityController::class, 'deleteMessage'])->name('erp.manager.messages.deleteMessage');
        Route::get('/messages/deleteChatMessage/{id}',[ChatsActivityController::class, 'deleteChatMessage'])->name('erp.manager.messages.deleteChatMessage');
        Route::get('/messages/readMessage/{id}', [ChatsActivityController::class, 'readMessage'])->name('erp.manager.messages.readMessage');
//        Route::get('/messages/update-notifications', [ChatsActivityController::class, 'updateNotifications'])->name('erp.manager.messages.updateNotifications');

        Route::get('/articles', [ArticleController::class, 'index'])->name('erp.manager.articles.index');
        Route::post('/articles/storeArticle', [ArticleController::class, 'storeArticle'])->name('erp.manager.articles.storeArticle');
        Route::get('/articles/showArticle/{id}', [ArticleController::class, 'showArticle'])->name('erp.manager.articles.showArticle');
        Route::put('/articles/addToFavorites/{id}', [ArticleController::class, 'addToFavorites'])->name('erp.manager.articles.addToFavorites');
        Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->name('erp.manager.articles.edit');
        Route::put('/articles/update/{id}', [ArticleController::class, 'updateArticle'])->name('erp.manager.articles.updateArticle');
        Route::get('/messages/deleteFile/{id}',[ArticleController::class, 'deleteFile'])->name('erp.manager.articles.deleteFile');
        Route::get('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('erp.manager.articles.delete');
        Route::get('/articles/search', [ArticleController::class, 'search'])->name('erp.manager.articles.search');


        // Route::get('/finances', [])

        // Route::post('/clients/personstore/{id}', [ClientBaseController::class, 'contactPersonStore'])->name('erp.manager.clients.contactPersonStore');
        // Route::get('/orders/trashed', [OrderController::class, 'onlyTrashed'])->name('erp.manager.orders.onlyTrased');
    });

    Route::middleware(['hr'])->prefix('hr')->group(function () {
        Route::get('/applicants', [ApplicantController::class, 'index'])->name('erp.hr.applicants.index');
        Route::get('/applicants/search', [ApplicantController::class, 'search'])->name('erp.hr.applicants.search');
        Route::get('/applicants/create', [ApplicantController::class, 'create'])->name('erp.hr.applicants.create');
        Route::post('/applicants/store', [ApplicantController::class, 'store'])->name('erp.hr.applicants.store');
        Route::get('/applicants/edit/{applicant}', [ApplicantController::class, 'edit'])->name('erp.hr.applicants.edit');
        Route::put('/applicants/edit/{applicant}', [ApplicantController::class, 'update'])->name('erp.hr.applicants.update');
        Route::get('/applicants/deleteDocument/{id}', [ApplicantController::class, 'deleteApplicantDocument'])->name('erp.hr.applicants.deleteApplicantDocument');
        Route::get('/applicants/delete/{applicant}', [ApplicantController::class, 'delete'])->name('erp.hr.applicants.delete');
        Route::get('/applicants/{id}', [ApplicantController::class, 'removeToInterviewee'])->name('erp.hr.applicants.removeToInterviewee');


        Route::get('/interviewees', [IntervieweeController::class, 'index'])->name('erp.hr.interviewees.index');
        Route::get('/interviewees/search', [IntervieweeController::class, 'search'])->name('erp.hr.interviewees.search');
        Route::get('/interviewees/edit/{interviewee}', [IntervieweeController::class, 'edit'])->name('erp.hr.interviewees.edit');
        Route::put('/interviewees/edit/{interviewee}', [IntervieweeController::class, 'update'])->name('erp.hr.interviewees.update');
//        Route::post('/interviewees/edit/{id}', [IntervieweeController::class, 'addDocuments'])->name('erp.hr.interviewees.add_documents');
//        Route::post('/interviewees/addphoto/{id}', [IntervieweeController::class, 'addPhoto'])->name('erp.hr.interviewees.addPhoto');
        Route::get('/interviewees/delete/{id}', [IntervieweeController::class, 'delete'])->name('erp.hr.interviewees.delete');
        Route::get('/interviewees/{id}', [IntervieweeController::class, 'removeToEmployees'])->name('erp.hr.interviewees.removeToEmployees');
        Route::get('/interviewees/deleteDocument/{id}', [IntervieweeController::class, 'deleteFile'])->name('erp.hr.interviewees.deleteFile');


        Route::get('/tasks', [UserTaskController::class, 'index'])->name('erp.hr.tasks.index');
        Route::post('/tasks/store', [UserTaskController::class, 'store'])->name('erp.hr.tasks.store');
        Route::get('/tasks/search',[UserTaskController::class,'search'])->name('erp.hr.tasks.search');
        Route::post('/tasks/remove', [UserTaskController::class, 'remove'])->name('erp.hr.tasks.remove');
        Route::post('/tasks/update', [UserTaskController::class, 'update'])->name('erp.hr.tasks.update');
        Route::post('/task/updateTaskColumn', [UserTaskController::class, 'updateTaskColumn'])->name('erp.hr.tasks.updateTaskColumn');
        Route::post('/task/storeKanban', [UserTaskController::class, 'storeKanban'])->name('erp.hr.tasks.storeKanban');
        Route::put('/task/updateKanban', [UserTaskController::class, 'updateKanban'])->name('erp.hr.tasks.updateKanban');
        Route::put('/task/updateKanbanTask', [UserTaskController::class, 'updateKanbanTask'])->name('erp.hr.tasks.updateKanbanTask');
        Route::get('/task/deleteKanban/{id}', [UserTaskController::class, 'deleteKanban'])->name('erp.hr.tasks.deleteKanban');
        Route::get('/task/deleteKanbanTask/{id}', [UserTaskController::class, 'deleteKanbanTask'])->name('erp.hr.tasks.deleteKanbanTask');
        Route::post('/task/storeKanbanTask', [UserTaskController::class, 'storeKanbanTask'])->name('erp.hr.tasks.storeKanbanTask');
        Route::get('/tasks/taskView/{id}', [UserTaskController::class, 'taskView'])->name('erp.hr.tasks.taskView');


        Route::get('/mail', [MailController::class, 'index'])->name('erp.hr.emails.index');
        Route::get('/mail/sendemails', [MailController::class, 'sendEmails'])->name('erp.hr.emails.sendEmails');
        Route::get('/mail/newemail', [MailController::class, 'newMail'])->name('erp.hr.emails.newMail');
        Route::post('/mail/sendemail', [MailController::class, 'sendMail'])->name('erp.hr.emails.sendMail');
        Route::get('/mail/getemails', [MailController::class,'getMails'])->name('erp.hr.emails.getMails');
        Route::get('/mail/openemail/{id}', [MailController::class, 'openEmail'])->name('erp.hr.emails.openEmail');
        Route::get('/mail/opensendemail/{id}', [MailController::class, 'openSendEmail'])->name('erp.hr.emails.openSendEmail');
        Route::put('/mail/deleteemail/', [MailController::class, 'deleteEmail'])->name('erp.hr.emails.deleteEmail');
        Route::put('/mail/forcedeleteemail', [MailController::class, 'forceDeleteEmails'])->name('erp.hr.emails.forceDeleteEmails');
        Route::get('/mail/deletedemails', [MailController::class, 'deletedEmails'])->name('erp.hr.emails.deletedEmails');
        Route::get('/mail/restoreemail/{id}', [MailController::class, 'restoreEmail'])->name('erp.hr.emails.restoreEmail');
        Route::get('/mail/search', [MailController::class, 'search'])->name('erp.hr.emails.search');
        Route::get('/mail/sendsSearch', [MailController::class,'sendsSearch'])->name('erp.hr.emails.sendEmailsSearch');

        Route::get('/messages', [ChatsActivityController::class, 'index'])->name('erp.hr.messages.index');
        Route::post('/messages/storeChat', [ChatsActivityController::class, 'storeChat'])->name('erp.hr.messages.storeChat');
        Route::post('/messages/storeMessage', [ChatsActivityController::class, 'storeMessage'])->name('erp.hr.messages.storeMessage');
        Route::put('/messages/updateMessage/{id}', [ChatsActivityController::class, 'updateMessage'])->name('erp.hr.messages.updateMessage');
        Route::put('/messages/updateChatMessage/{id}', [ChatsActivityController::class, 'updateChatMessage'])->name('erp.hr.messages.updateChatMessage');
//        Route::post('/messages/storePrivatMessage', [ChatsActivityController::class, 'storePrivatMessage'])->name('erp.hr.messages.storePrivatMessage');
        Route::get('/messages/showChat/{id}', [ChatsActivityController::class, 'showChat'])->name('erp.hr.messages.showChat');
        Route::get('/messages/showPrivatChat/{id}', [ChatsActivityController::class, 'showPrivatChat'])->name('erp.hr.messages.showPrivatChat');
        Route::post('/messages/storeChatMessage/{id}',[ChatsActivityController::class,'storeChatMessage'])->name('erp.hr.messages.storeChatMessage');
        Route::post('/messages/addUser/{id}', [ChatsActivityController::class, 'addUser'])->name('erp.hr.messages.addUser');
        Route::get('/messages/deleteChat/{id}', [ChatsActivityController::class, 'deleteChat'])->name('erp.hr.messages.deleteChat');
        Route::put('/messages/updateChat/{id}', [ChatsActivityController::class, 'updateChat'])->name('erp.hr.messages.updateChat');
        Route::get('/messages/searchUsers', [ChatsActivityController::class, 'searchUsers'])->name('erp.hr.messages.searchUsers');
        Route::get('/messages/search', [ChatsActivityController::class, 'search'])->name('erp.hr.messages.search');
        Route::post('/messages/messageReply/{id}', [ChatsActivityController::class, 'messageReply'])->name('erp.hr.messages.messageReply');
        Route::post('/messages/chatReply/{id}', [ChatsActivityController::class, 'chatReply'])->name('erp.hr.messages.chatReply');
        Route::get('/messages/deleteMessage/{id}',[ChatsActivityController::class, 'deleteMessage'])->name('erp.hr.messages.deleteMessage');
        Route::get('/messages/deleteChatMessage/{id}',[ChatsActivityController::class, 'deleteChatMessage'])->name('erp.hr.messages.deleteChatMessage');
        Route::get('/messages/readMessage/{id}', [ChatsActivityController::class, 'readMessage'])->name('erp.hr.messages.readMessage');
//        Route::get('/messages/update-notifications', [ChatsActivityController::class, 'updateNotifications'])->name('erp.hr.messages.updateNotifications');

        Route::get('/articles', [ArticleController::class, 'index'])->name('erp.hr.articles.index');
        Route::post('/articles/storeArticle', [ArticleController::class, 'storeArticle'])->name('erp.hr.articles.storeArticle');
        Route::get('/articles/showArticle/{id}', [ArticleController::class, 'showArticle'])->name('erp.hr.articles.showArticle');
        Route::put('/articles/addToFavorites/{id}', [ArticleController::class, 'addToFavorites'])->name('erp.hr.articles.addToFavorites');
        Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->name('erp.hr.articles.edit');
        Route::put('/articles/update/{id}', [ArticleController::class, 'updateArticle'])->name('erp.hr.articles.updateArticle');
        Route::get('/messages/deleteFile/{id}',[ArticleController::class, 'deleteFile'])->name('erp.hr.articles.deleteFile');
        Route::get('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('erp.hr.articles.delete');
        Route::get('/articles/search', [ArticleController::class, 'search'])->name('erp.hr.articles.search');


    });

    Route::middleware(['logist'])->prefix('logist')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('erp.logist.orders.index');
        Route::get('/orders/search', [OrderController::class, 'search'])->name('erp.logist.orders.search');
        Route::get('/orders/edit/{order}', [OrderController::class, 'edit'])->name('erp.logist.orders.edit');
        Route::post('/orders/edit/addcomment/{id}', [OrderController::class, 'addcomment'])->name('erp.logist.orders.addComment');
        Route::get('/orders/{id}', [OrderController::class, 'completion'])->name('erp.logist.orders.completion');
        Route::post('/orders/{id}', [OrderController::class, 'addMover'])->name('erp.logist.orders.addMover');
        Route::get('/orders/sortByDescription', [OrderController::class, 'sortByDescription'])->name('erp.logist.orders.sortByDescription');
        Route::get('/orders/removeMover/{id}', [OrderController::class, 'removeMover'])->name('erp.logist.orders.removeMover');
        Route::get('/orders/datesort', [OrderController::class, 'sortByDateTab'])->name('erp.logist.orders.sortByDateTab');

        Route::get('/movers', [MoverController::class, 'index'])->name('erp.logist.movers.index');
        Route::get('/movers/search', [MoverController::class, 'search'])->name('erp.logist.movers.search');
        Route::get('/movers/planningSearch', [MoverController::class, 'planningSearch'])->name('erp.logist.movers.planningSearch');
        Route::get('/movers/create', [MoverController::class, 'create'])->name('erp.logist.movers.create');
        Route::post('/movers/store', [MoverController::class, 'store'])->name('erp.logist.movers.store');
        Route::get('/movers/planning', [MoverController::class, 'planning'])->name('erp.logist.movers.planning');
        Route::get('/movers/delete/{id}', [MoverController::class, 'delete'])->name('erp.logist.movers.delete');
        Route::post('/movers/addBonus/{id}', [MoverController::class, 'addBonus'])->name('erp.logist.movers.addbonus');
        Route::post('/movers/payToMover/{id}', [MoverController::class, 'payToMover'])->name('erp.logist.movers.payToMover');
        Route::get('/movers/edit/{id}', [MoverController::class, 'edit'])->name('erp.logist.movers.edit');
        Route::post('/movers/addphoto/{id}', [MoverController::class, 'addPhoto'])->name('erp.logist.movers.addPhoto');
        Route::put('/movers/update/{id}', [MoverController::class, 'update'])->name('erp.logist.movers.update');

        Route::get('/tasks', [UserTaskController::class, 'index'])->name('erp.logist.tasks.index');
        Route::post('/tasks/store', [UserTaskController::class, 'store'])->name('erp.logist.tasks.store');
        Route::get('/tasks/search',[UserTaskController::class,'search'])->name('erp.logist.tasks.search');
        Route::post('/tasks/remove', [UserTaskController::class, 'remove'])->name('erp.logist.tasks.remove');
        Route::post('/tasks/update', [UserTaskController::class, 'update'])->name('erp.logist.tasks.update');
        Route::post('/task/updateTaskColumn', [UserTaskController::class, 'updateTaskColumn'])->name('erp.logist.tasks.updateTaskColumn');
        Route::post('/task/storeKanban', [UserTaskController::class, 'storeKanban'])->name('erp.logist.tasks.storeKanban');
        Route::put('/task/updateKanban', [UserTaskController::class, 'updateKanban'])->name('erp.logist.tasks.updateKanban');
        Route::put('/task/updateKanbanTask', [UserTaskController::class, 'updateKanbanTask'])->name('erp.logist.tasks.updateKanbanTask');
        Route::get('/task/deleteKanban/{id}', [UserTaskController::class, 'deleteKanban'])->name('erp.logist.tasks.deleteKanban');
        Route::get('/task/deleteKanbanTask/{id}', [UserTaskController::class, 'deleteKanbanTask'])->name('erp.logist.tasks.deleteKanbanTask');
        Route::post('/task/storeKanbanTask', [UserTaskController::class, 'storeKanbanTask'])->name('erp.logist.tasks.storeKanbanTask');
        Route::get('/tasks/taskView/{id}', [UserTaskController::class, 'taskView'])->name('erp.logist.tasks.taskView');


        Route::get('/mail', [MailController::class, 'index'])->name('erp.logist.emails.index');
        Route::get('/mail/sendemails', [MailController::class, 'sendEmails'])->name('erp.logist.emails.sendEmails');
        Route::get('/mail/newemail', [MailController::class, 'newMail'])->name('erp.logist.emails.newMail');
        Route::post('/mail/sendemail', [MailController::class, 'sendMail'])->name('erp.logist.emails.sendMail');
        Route::get('/mail/getemails', [MailController::class,'getMails'])->name('erp.logist.emails.getMails');
        Route::get('/mail/openemail/{id}', [MailController::class, 'openEmail'])->name('erp.logist.emails.openEmail');
        Route::get('/mail/opensendemail/{id}', [MailController::class, 'openSendEmail'])->name('erp.logist.emails.openSendEmail');
        Route::put('/mail/deleteemail/', [MailController::class, 'deleteEmail'])->name('erp.logist.emails.deleteEmail');
        Route::put('/mail/forcedeleteemail', [MailController::class, 'forceDeleteEmails'])->name('erp.logist.emails.forceDeleteEmails');
        Route::get('/mail/deletedemails', [MailController::class, 'deletedEmails'])->name('erp.logist.emails.deletedEmails');
        Route::get('/mail/restoreemail/{id}', [MailController::class, 'restoreEmail'])->name('erp.logist.emails.restoreEmail');
        Route::get('/mail/search', [MailController::class, 'search'])->name('erp.logist.emails.search');
        Route::get('/mail/sendsSearch', [MailController::class,'sendsSearch'])->name('erp.logist.emails.sendEmailsSearch');

        Route::get('/messages', [ChatsActivityController::class, 'index'])->name('erp.logist.messages.index');
        Route::post('/messages/storeChat', [ChatsActivityController::class, 'storeChat'])->name('erp.logist.messages.storeChat');
        Route::post('/messages/storeMessage', [ChatsActivityController::class, 'storeMessage'])->name('erp.logist.messages.storeMessage');
        Route::put('/messages/updateMessage/{id}', [ChatsActivityController::class, 'updateMessage'])->name('erp.logist.messages.updateMessage');
        Route::put('/messages/updateChatMessage/{id}', [ChatsActivityController::class, 'updateChatMessage'])->name('erp.logist.messages.updateChatMessage');
//        Route::post('/messages/storePrivatMessage', [ChatsActivityController::class, 'storePrivatMessage'])->name('erp.logist.messages.storePrivatMessage');
        Route::get('/messages/showChat/{id}', [ChatsActivityController::class, 'showChat'])->name('erp.logist.messages.showChat');
        Route::get('/messages/showPrivatChat/{id}', [ChatsActivityController::class, 'showPrivatChat'])->name('erp.logist.messages.showPrivatChat');
        Route::post('/messages/storeChatMessage/{id}',[ChatsActivityController::class,'storeChatMessage'])->name('erp.logist.messages.storeChatMessage');
        Route::post('/messages/addUser/{id}', [ChatsActivityController::class, 'addUser'])->name('erp.logist.messages.addUser');
        Route::get('/messages/deleteChat/{id}', [ChatsActivityController::class, 'deleteChat'])->name('erp.logist.messages.deleteChat');
        Route::put('/messages/updateChat/{id}', [ChatsActivityController::class, 'updateChat'])->name('erp.logist.messages.updateChat');
        Route::get('/messages/searchUsers', [ChatsActivityController::class, 'searchUsers'])->name('erp.logist.messages.searchUsers');
        Route::get('/messages/search', [ChatsActivityController::class, 'search'])->name('erp.logist.messages.search');
        Route::post('/messages/messageReply/{id}', [ChatsActivityController::class, 'messageReply'])->name('erp.logist.messages.messageReply');
        Route::post('/messages/chatReply/{id}', [ChatsActivityController::class, 'chatReply'])->name('erp.logist.messages.chatReply');
        Route::get('/messages/deleteMessage/{id}',[ChatsActivityController::class, 'deleteMessage'])->name('erp.logist.messages.deleteMessage');
        Route::get('/messages/deleteChatMessage/{id}',[ChatsActivityController::class, 'deleteChatMessage'])->name('erp.logist.messages.deleteChatMessage');
        Route::get('/messages/readMessage/{id}', [ChatsActivityController::class, 'readMessage'])->name('erp.logist.messages.readMessage');
//        Route::get('/messages/update-notifications', [ChatsActivityController::class, 'updateNotifications'])->name('erp.logist.messages.updateNotifications');

        Route::get('/articles', [ArticleController::class, 'index'])->name('erp.logist.articles.index');
        Route::post('/articles/storeArticle', [ArticleController::class, 'storeArticle'])->name('erp.logist.articles.storeArticle');
        Route::get('/articles/showArticle/{id}', [ArticleController::class, 'showArticle'])->name('erp.logist.articles.showArticle');
        Route::put('/articles/addToFavorites/{id}', [ArticleController::class, 'addToFavorites'])->name('erp.logist.articles.addToFavorites');
        Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->name('erp.logist.articles.edit');
        Route::put('/articles/update/{id}', [ArticleController::class, 'updateArticle'])->name('erp.logist.articles.updateArticle');
        Route::get('/messages/deleteFile/{id}',[ArticleController::class, 'deleteFile'])->name('erp.logist.articles.deleteFile');
        Route::get('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('erp.logist.articles.delete');
        Route::get('/articles/search', [ArticleController::class, 'search'])->name('erp.logist.articles.search');





        // Route::post('/orders/storemover/{id}', [OrderController::class, 'addMover'])->name('erp.logist.orders.storeAddMover');

    });

    Route::middleware(['accountant'])->prefix('accountant')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('erp.accountant.orders.index');
        Route::get('/orders/edit/{order}', [OrderController::class, 'edit'])->name('erp.accountant.orders.edit');
        Route::post('/orders/edit/{id}', [OrderController::class, 'addFiles'])->name('erp.accountant.orders.addFiles');
        Route::post('/orders/edit/addComment/{id}', [OrderController::class, 'addComment'])->name('erp.accountant.orders.addComment');
        Route::put('/orders/{id}', [OrderController::class, 'toBankOperations'])->name('erp.accountant.orders.toBankOperations');
        Route::delete('/orders/edit/{id}', [OrderController::class, 'deleteFile'])->name('erp.accountant.orders.deleteFile');
        Route::get('/orders/search', [OrderController::class, 'search'])->name('erp.accountant.orders.search');

        Route::get('/finances', [BankOperationController::class, 'index'])->name('erp.accountant.finances.index');
        Route::get('/finances/search', [BankOperationController::class, 'search'])->name('erp.accountant.finances.search');
        Route::get('/report', [FinanceController::class, 'index'])->name('erp.accountant.report');

        Route::get('/clients', [ClientBaseController::class, 'index'])->name('erp.accountant.clients.index');
        Route::get('/clients/search', [ClientBaseController::class, 'search'])->name('erp.accountant.clients.search');
        Route::get('/clients/edit/{clientBase}', [ClientBaseController::class, 'edit'])->name('erp.accountant.clients.edit');
        Route::put('/clients/edit/{clientBase}', [ClientBaseController::class, 'update'])->name('erp.accountant.clients.update');
        Route::get('/clients/delete/{clientBase}', [ClientBaseController::class, 'destroy'])->name('erp.accountant.clients.delete');
        Route::post('/clients/edit/{id}', [ClientBaseController::class, 'addFiles'])->name('erp.accountant.clients.addFiles');
        Route::delete('/clients/deletefile/{id}', [ClientBaseController::class, 'deleteFile'])->name('erp.accountant.clients.deleteFile');
        Route::get('/clients/{id}', [ClientBaseController::class, 'clientContactDelete'])->name('erp.accountant.clients.client_delete');
        Route::post('/clients/edit/addComment/{id}', [ClientBaseController::class, 'addComment'])->name('erp.accountant.clients.addComment');
        Route::get('/clients/acc/create', [ClientBaseController::class, 'create'])->name('erp.accountant.clients.create');
        Route::post('/clients/acc/store', [ClientBaseController::class, 'store'])->name('erp.accountant.clients.store');


        Route::get('/arrears', [ArrearController::class, 'index'])->name('erp.accountant.arrears.index');
        Route::get('/arrears/search', [ArrearController::class, 'search'])->name('erp.accountant.arrears.search');

        Route::get('/tasks', [UserTaskController::class, 'index'])->name('erp.accountant.tasks.index');
        Route::post('/tasks/store', [UserTaskController::class, 'store'])->name('erp.accountant.tasks.store');
        Route::get('/tasks/search',[UserTaskController::class,'search'])->name('erp.accountant.tasks.search');
        Route::post('/tasks/remove', [UserTaskController::class, 'remove'])->name('erp.accountant.tasks.remove');
        Route::post('/tasks/update', [UserTaskController::class, 'update'])->name('erp.accountant.tasks.update');
        Route::post('/task/updateTaskColumn', [UserTaskController::class, 'updateTaskColumn'])->name('erp.accountant.tasks.updateTaskColumn');
        Route::post('/task/storeKanban', [UserTaskController::class, 'storeKanban'])->name('erp.accountant.tasks.storeKanban');
        Route::put('/task/updateKanban', [UserTaskController::class, 'updateKanban'])->name('erp.accountant.tasks.updateKanban');
        Route::put('/task/updateKanbanTask', [UserTaskController::class, 'updateKanbanTask'])->name('erp.accountant.tasks.updateKanbanTask');
        Route::get('/task/deleteKanban/{id}', [UserTaskController::class, 'deleteKanban'])->name('erp.accountant.tasks.deleteKanban');
        Route::get('/task/deleteKanbanTask/{id}', [UserTaskController::class, 'deleteKanbanTask'])->name('erp.accountant.tasks.deleteKanbanTask');
        Route::post('/task/storeKanbanTask', [UserTaskController::class, 'storeKanbanTask'])->name('erp.accountant.tasks.storeKanbanTask');
        Route::get('/tasks/taskView/{id}', [UserTaskController::class, 'taskView'])->name('erp.accountant.tasks.taskView');


        Route::get('/mail', [MailController::class, 'index'])->name('erp.accountant.emails.index');
        Route::get('/mail/sendemails', [MailController::class, 'sendEmails'])->name('erp.accountant.emails.sendEmails');
        Route::get('/mail/newemail', [MailController::class, 'newMail'])->name('erp.accountant.emails.newMail');
        Route::post('/mail/sendemail', [MailController::class, 'sendMail'])->name('erp.accountant.emails.sendMail');
        Route::get('/mail/getemails', [MailController::class,'getMails'])->name('erp.accountant.emails.getMails');
        Route::get('/mail/openemail/{id}', [MailController::class, 'openEmail'])->name('erp.accountant.emails.openEmail');
        Route::get('/mail/opensendemail/{id}', [MailController::class, 'openSendEmail'])->name('erp.accountant.emails.openSendEmail');
        Route::put('/mail/deleteemail/', [MailController::class, 'deleteEmail'])->name('erp.accountant.emails.deleteEmail');
        Route::put('/mail/forcedeleteemail', [MailController::class, 'forceDeleteEmails'])->name('erp.accountant.emails.forceDeleteEmails');
        Route::get('/mail/deletedemails', [MailController::class, 'deletedEmails'])->name('erp.accountant.emails.deletedEmails');
        Route::get('/mail/restoreemail/{id}', [MailController::class, 'restoreEmail'])->name('erp.accountant.emails.restoreEmail');
        Route::get('/mail/search', [MailController::class, 'search'])->name('erp.accountant.emails.search');
        Route::get('/mail/sendsSearch', [MailController::class,'sendsSearch'])->name('erp.accountant.emails.sendEmailsSearch');

        Route::get('/messages', [ChatsActivityController::class, 'index'])->name('erp.accountant.messages.index');
        Route::post('/messages/storeChat', [ChatsActivityController::class, 'storeChat'])->name('erp.accountant.messages.storeChat');
        Route::post('/messages/storeMessage', [ChatsActivityController::class, 'storeMessage'])->name('erp.accountant.messages.storeMessage');
        Route::put('/messages/updateMessage/{id}', [ChatsActivityController::class, 'updateMessage'])->name('erp.accountant.messages.updateMessage');
        Route::put('/messages/updateChatMessage/{id}', [ChatsActivityController::class, 'updateChatMessage'])->name('erp.accountant.messages.updateChatMessage');
//        Route::post('/messages/storePrivatMessage', [ChatsActivityController::class, 'storePrivatMessage'])->name('erp.accountant.messages.storePrivatMessage');
        Route::get('/messages/showChat/{id}', [ChatsActivityController::class, 'showChat'])->name('erp.accountant.messages.showChat');
        Route::get('/messages/showPrivatChat/{id}', [ChatsActivityController::class, 'showPrivatChat'])->name('erp.accountant.messages.showPrivatChat');
        Route::post('/messages/storeChatMessage/{id}',[ChatsActivityController::class,'storeChatMessage'])->name('erp.accountant.messages.storeChatMessage');
        Route::post('/messages/addUser/{id}', [ChatsActivityController::class, 'addUser'])->name('erp.accountant.messages.addUser');
        Route::get('/messages/deleteChat/{id}', [ChatsActivityController::class, 'deleteChat'])->name('erp.accountant.messages.deleteChat');
        Route::put('/messages/updateChat/{id}', [ChatsActivityController::class, 'updateChat'])->name('erp.accountant.messages.updateChat');
        Route::get('/messages/searchUsers', [ChatsActivityController::class, 'searchUsers'])->name('erp.accountant.messages.searchUsers');
        Route::get('/messages/search', [ChatsActivityController::class, 'search'])->name('erp.accountant.messages.search');
        Route::post('/messages/messageReply/{id}', [ChatsActivityController::class, 'messageReply'])->name('erp.accountant.messages.messageReply');
        Route::post('/messages/chatReply/{id}', [ChatsActivityController::class, 'chatReply'])->name('erp.accountant.messages.chatReply');
        Route::get('/messages/deleteMessage/{id}',[ChatsActivityController::class, 'deleteMessage'])->name('erp.accountant.messages.deleteMessage');
        Route::get('/messages/deleteChatMessage/{id}',[ChatsActivityController::class, 'deleteChatMessage'])->name('erp.accountant.messages.deleteChatMessage');
        Route::get('/messages/readMessage/{id}', [ChatsActivityController::class, 'readMessage'])->name('erp.accountant.messages.readMessage');
//        Route::get('/messages/update-notifications', [ChatsActivityController::class, 'updateNotifications'])->name('erp.accountant.messages.updateNotifications');

        Route::get('/articles', [ArticleController::class, 'index'])->name('erp.accountant.articles.index');
        Route::post('/articles/storeArticle', [ArticleController::class, 'storeArticle'])->name('erp.accountant.articles.storeArticle');
        Route::get('/articles/showArticle/{id}', [ArticleController::class, 'showArticle'])->name('erp.accountant.articles.showArticle');
        Route::put('/articles/addToFavorites/{id}', [ArticleController::class, 'addToFavorites'])->name('erp.accountant.articles.addToFavorites');
        Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->name('erp.accountant.articles.edit');
        Route::put('/articles/update/{id}', [ArticleController::class, 'updateArticle'])->name('erp.accountant.articles.updateArticle');
        Route::get('/messages/deleteFile/{id}',[ArticleController::class, 'deleteFile'])->name('erp.accountant.articles.deleteFile');
        Route::get('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('erp.accountant.articles.delete');
        Route::get('/articles/search', [ArticleController::class, 'search'])->name('erp.accountant.articles.search');



    });

    Route::middleware(['executive'])->prefix('executive')->group(function () {
        Route::get('/leads', [LeadController::class, 'index'])->name('erp.executive.leads.index');
        Route::get('/leads/search', [LeadController::class, 'search'])->name('erp.executive.leads.search');
        Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('erp.executive.leads.update');
        Route::get('/leads/toOrder/{id}', [LeadController::class, 'toOrder'])->name('erp.executive.leads.toOrder');
//        Route::get('/leads/delete/{lead}', [LeadController::class, 'delete'])->name('erp.executive.leads.delete');
        Route::get('/leads/destroy/{lead}', [LeadController::class, 'destroy'])->name('erp.executive.leads.destroy');
        Route::get('/leads/deleteFile/{id}', [LeadController::class, 'deleteFile'])->name('erp.executive.leads.deleteFile');

        Route::post('/leads/store',[LeadController::class, 'store'])->name('erp.executive.leads.store');

        Route::get('/orders', [OrderController::class, 'index'])->name('erp.executive.orders.index');
        Route::get('/orders/priceSort', [OrderController::class, 'sortByPriceTab'])->name('erp.executive.orders.sortByPriceTab');
        Route::get('/orders/dateSort', [OrderController::class, 'sortByDateTab'])->name('erp.executive.orders.sortByDateTab');
        Route::get('/orders/sortByDescription', [OrderController::class, 'sortByDescription'])->name('erp.executive.orders.sortByDescription');
        Route::get('/orders/sortByCompany', [OrderController::class, 'sortByCompany'])->name('erp.executive.orders.sortByCompany');
        Route::get('/orders/search', [OrderController::class, 'search'])->name('erp.executive.orders.search');
        Route::get('/orders/edit/{order}', [OrderController::class, 'edit'])->name('erp.executive.orders.edit');
        Route::put('/orders/edit/{order}', [OrderController::class, 'update'])->name('erp.executive.orders.update');
        Route::put('/orders/{id}', [OrderController::class, 'toBankOperations'])->name('erp.executive.orders.toBankOperations');
        Route::get('/orders/{id}', [OrderController::class, 'takeAtWork'])->name('erp.executive.orders.takeAtWork');
        Route::get('/orders/new/create', [OrderController::class, 'create'])->name('erp.executive.orders.create');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('erp.executive.orders.store');
        Route::get('/orders/delete/{order}', [OrderController::class, 'destroy'])->name('erp.executive.orders.delete');
        Route::get('/orders/cancellation/{order}', [OrderController::class, 'cancellation'])->name('erp.executive.orders.cancellation');
        Route::get('/orders/return/{order}', [OrderController::class, 'return'])->name('erp.executive.orders.return');
        Route::post('/orders/edit/{id}', [OrderController::class, 'addFiles'])->name('erp.executive.orders.addFiles');
        Route::delete('/orders/edit/{id}', [OrderController::class, 'deleteFile'])->name('erp.executive.orders.deleteFile');
        Route::post('/orders/edit/addComment/{id}', [OrderController::class, 'addComment'])->name('erp.executive.orders.addComment');

        Route::get('/movers', [MoverController::class, 'index'])->name('erp.executive.movers.index');
        Route::get('/movers/search', [MoverController::class, 'search'])->name('erp.executive.movers.search');
        Route::get('/movers/planningSearch', [MoverController::class, 'planningSearch'])->name('erp.executive.movers.planningSearch');
        Route::get('/movers/create', [MoverController::class, 'create'])->name('erp.executive.movers.create');
        Route::post('/movers/store', [MoverController::class, 'store'])->name('erp.executive.movers.store');
        Route::get('/movers/planning', [MoverController::class, 'planning'])->name('erp.executive.movers.planning');
        Route::get('/movers/delete/{id}', [MoverController::class, 'delete'])->name('erp.executive.movers.delete');
        Route::post('/movers/addBonus/{id}', [MoverController::class, 'addBonus'])->name('erp.executive.movers.addbonus');
        Route::post('/movers/payToMover/{id}', [MoverController::class, 'payToMover'])->name('erp.executive.movers.payToMover');
        Route::get('/movers/edit/{id}', [MoverController::class, 'edit'])->name('erp.executive.movers.edit');
        Route::post('/movers/addphoto/{id}', [MoverController::class, 'addPhoto'])->name('erp.executive.movers.addPhoto');
        Route::put('/movers/update/{id}', [MoverController::class, 'update'])->name('erp.executive.movers.update');

        Route::get('/applicants', [ApplicantController::class, 'index'])->name('erp.executive.applicants.index');
        Route::get('/applicants/search', [ApplicantController::class, 'search'])->name('erp.executive.applicants.search');
        Route::get('/applicants/create', [ApplicantController::class, 'create'])->name('erp.executive.applicants.create');
        Route::post('/applicants/store', [ApplicantController::class, 'store'])->name('erp.executive.applicants.store');
        Route::get('/applicants/edit/{applicant}', [ApplicantController::class, 'edit'])->name('erp.executive.applicants.edit');
        Route::put('/applicants/edit/{applicant}', [ApplicantController::class, 'update'])->name('erp.executive.applicants.update');
        Route::get('/applicants/deleteDocument/{id}', [ApplicantController::class, 'deleteApplicantDocument'])->name('erp.executive.applicants.deleteApplicantDocument');
        Route::get('/applicants/delete/{applicant}', [ApplicantController::class, 'delete'])->name('erp.executive.applicants.delete');
        Route::get('/applicants/{id}', [ApplicantController::class, 'removeToInterviewee'])->name('erp.executive.applicants.removeToInterviewee');

        Route::get('/arrears', [ArrearController::class, 'index'])->name('erp.executive.arrears.index');
        Route::get('/arrears/search', [ArrearController::class, 'search'])->name('erp.executive.arrears.search');

        Route::get('/interviewees', [IntervieweeController::class, 'index'])->name('erp.executive.interviewees.index');
        Route::get('/interviewees/search', [IntervieweeController::class, 'search'])->name('erp.executive.interviewees.search');
        Route::get('/interviewees/edit/{interviewee}', [IntervieweeController::class, 'edit'])->name('erp.executive.interviewees.edit');
        Route::put('/interviewees/edit/{interviewee}', [IntervieweeController::class, 'update'])->name('erp.executive.interviewees.update');
//        Route::post('/interviewees/edit/{id}', [IntervieweeController::class, 'addDocuments'])->name('erp.executive.interviewees.add_documents');
//        Route::post('/interviewees/addphoto/{id}', [IntervieweeController::class, 'addPhoto'])->name('erp.executive.interviewees.addPhoto');
        Route::get('/interviewees/delete/{id}', [IntervieweeController::class, 'delete'])->name('erp.executive.interviewees.delete');
        Route::get('/interviewees/{id}', [IntervieweeController::class, 'removeToEmployees'])->name('erp.executive.interviewees.removeToEmployees');
        Route::get('/interviewees/deleteDocument/{id}', [IntervieweeController::class, 'deleteFile'])->name('erp.executive.interviewees.deleteFile');


        Route::get('/clients', [ClientBaseController::class, 'index'])->name('erp.executive.clients.index');
        Route::get('/clients/search', [ClientBaseController::class, 'search'])->name('erp.executive.clients.search');
        Route::get('/clients/edit/{clientBase}', [ClientBaseController::class, 'edit'])->name('erp.executive.clients.edit');
        Route::put('/clients/edit/{clientBase}', [ClientBaseController::class, 'update'])->name('erp.executive.clients.update');
        Route::get('/clients/delete/{clientBase}', [ClientBaseController::class, 'destroy'])->name('erp.executive.clients.delete');
        Route::post('/clients/edit/{id}', [ClientBaseController::class, 'addFiles'])->name('erp.executive.clients.addFiles');
        Route::delete('/clients/deletefile/{id}', [ClientBaseController::class, 'deleteFile'])->name('erp.executive.clients.deleteFile');
        Route::get('/clients/{id}', [ClientBaseController::class, 'clientContactDelete'])->name('erp.executive.clients.client_delete');
        Route::post('/clients/edit/addComment/{id}', [ClientBaseController::class, 'addComment'])->name('erp.executive.clients.addComment');
        Route::get('/clients/new/create', [ClientBaseController::class, 'create'])->name('erp.executive.clients.create');
        Route::post('/clients/store', [ClientBaseController::class, 'store'])->name('erp.executive.clients.store');


        Route::get('/finances', [BankOperationController::class, 'index'])->name('erp.executive.finances.index');
        Route::get('/finances/search', [BankOperationController::class, 'search'])->name('erp.executive.finances.search');
        Route::get('/report', [FinanceController::class, 'index'])->name('erp.executive.report');


        Route::get('/tasks', [UserTaskController::class, 'index'])->name('erp.executive.tasks.index');
        Route::post('/tasks/store', [UserTaskController::class, 'store'])->name('erp.executive.tasks.store');
        Route::get('/tasks/search',[UserTaskController::class,'search'])->name('erp.executive.tasks.search');
        Route::post('/task/storeKanban', [UserTaskController::class, 'storeKanban'])->name('erp.executive.tasks.storeKanban');
        Route::put('/task/updateKanban', [UserTaskController::class, 'updateKanban'])->name('erp.executive.tasks.updateKanban');
        Route::put('/task/updateKanbanTask', [UserTaskController::class, 'updateKanbanTask'])->name('erp.executive.tasks.updateKanbanTask');
        Route::get('/task/deleteKanban/{id}', [UserTaskController::class, 'deleteKanban'])->name('erp.executive.tasks.deleteKanban');
        Route::get('/task/deleteKanbanTask/{id}', [UserTaskController::class, 'deleteKanbanTask'])->name('erp.executive.tasks.deleteKanbanTask');
        Route::post('/task/storeKanbanTask', [UserTaskController::class, 'storeKanbanTask'])->name('erp.executive.tasks.storeKanbanTask');
        Route::post('/task/updateTaskColumn', [UserTaskController::class, 'updateTaskColumn'])->name('erp.executive.tasks.updateTaskColumn');
        Route::post('/tasks/remove', [UserTaskController::class, 'remove'])->name('erp.executive.tasks.remove');
        Route::post('/tasks/update', [UserTaskController::class, 'update'])->name('erp.executive.tasks.update');
        Route::get('/tasks/taskView/{id}', [UserTaskController::class, 'taskView'])->name('erp.executive.tasks.taskView');

        Route::get('/employees', [EmployeeController::class, 'index'])->name('erp.executive.employees.index');
        Route::get('/employees/search', [EmployeeController::class, 'search'])->name('erp.executive.employees.search');
        // Route::get('/movers/planningSearch', [MoverController::class, 'planningSearch'])->name('erp.executive.movers.planningSearch');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('erp.executive.employees.create');
        Route::post('/employees/store', [EmployeeController::class, 'store'])->name('erp.executive.employees.store');
        // Route::get('/movers/planning', [MoverController::class, 'planning'])->name('erp.executive.movers.planning');
        Route::get('/employees/delete/{id}', [EmployeeController::class, 'delete'])->name('erp.executive.employees.delete');
        // Route::post('/movers/addbonus/{id}', [MoverController::class, 'addbonus'])->name('erp.executive.movers.addbonus');
        // Route::post('/movers/payToMover/{id}', [MoverController::class, 'payToMover'])->name('erp.executive.movers.payToMover');
        Route::get('/employees/edit/{id}', [EmployeeController::class, 'edit'])->name('erp.executive.employees.edit');
        Route::put('/employees/update/{id}', [EmployeeController::class, 'update'])->name('erp.executive.employees.update');
        Route::get('/employees/deleteDocument/{id}', [EmployeeController::class, 'deleteEmployeeDocument'])->name('erp.executive.employees.deleteEmployeeDocument');


        // Route::get('/mail', [GmailController::class, 'index'])->name('gmail.index');
        // Route::get('/redirect-to-google', [GmailController::class,'redirectToGoogle']);
        // Route::get('/google-callback', [GmailController::class,'handleGoogleCallback']);

        Route::get('/mail', [MailController::class, 'index'])->name('erp.executive.emails.index');
        Route::get('/mail/sendEmails', [MailController::class, 'sendEmails'])->name('erp.executive.emails.sendEmails');
        Route::get('/mail/newemail', [MailController::class, 'newMail'])->name('erp.executive.emails.newMail');
        Route::post('/mail/sendemail', [MailController::class, 'sendMail'])->name('erp.executive.emails.sendMail');
        Route::get('/mail/getemails', [MailController::class,'getMails'])->name('erp.executive.emails.getMails');
        Route::get('/mail/openemail/{id}', [MailController::class, 'openEmail'])->name('erp.executive.emails.openEmail');
        Route::get('/mail/opensendemail/{id}', [MailController::class, 'openSendEmail'])->name('erp.executive.emails.openSendEmail');
        Route::put('/mail/deleteemail/', [MailController::class, 'deleteEmail'])->name('erp.executive.emails.deleteEmail');
        Route::put('/mail/forcedeleteemail', [MailController::class, 'forceDeleteEmails'])->name('erp.executive.emails.forceDeleteEmails');
        Route::get('/mail/deletedemails', [MailController::class, 'deletedEmails'])->name('erp.executive.emails.deletedEmails');
        Route::get('/mail/restoreemail/{id}', [MailController::class, 'restoreEmail'])->name('erp.executive.emails.restoreEmail');
        Route::get('/mail/search', [MailController::class, 'search'])->name('erp.executive.emails.search');
        Route::get('/mail/sendsSearch', [MailController::class,'sendsSearch'])->name('erp.executive.emails.sendEmailsSearch');

        Route::get('/messages', [ChatsActivityController::class, 'index'])->name('erp.executive.messages.index');
        Route::post('/messages/storeChat', [ChatsActivityController::class, 'storeChat'])->name('erp.executive.messages.storeChat');
        Route::post('/messages/storeMessage', [ChatsActivityController::class, 'storeMessage'])->name('erp.executive.messages.storeMessage');
        Route::put('/messages/updateMessage/{id}', [ChatsActivityController::class, 'updateMessage'])->name('erp.executive.messages.updateMessage');
        Route::put('/messages/updateChatMessage/{id}', [ChatsActivityController::class, 'updateChatMessage'])->name('erp.executive.messages.updateChatMessage');
        Route::get('/messages/search', [ChatsActivityController::class, 'search'])->name('erp.executive.messages.search');
        Route::get('/messages/showChat/{id}', [ChatsActivityController::class, 'showChat'])->name('erp.executive.messages.showChat');
        Route::get('/messages/showPrivatChat/{id}', [ChatsActivityController::class, 'showPrivatChat'])->name('erp.executive.messages.showPrivatChat');
        Route::post('/messages/storeChatMessage/{id}',[ChatsActivityController::class,'storeChatMessage'])->name('erp.executive.messages.storeChatMessage');
        Route::post('/messages/addUser/{id}', [ChatsActivityController::class, 'addUser'])->name('erp.executive.messages.addUser');
        Route::get('/messages/deleteChat/{id}', [ChatsActivityController::class, 'deleteChat'])->name('erp.executive.messages.deleteChat');
        Route::put('/messages/updateChat/{id}', [ChatsActivityController::class, 'updateChat'])->name('erp.executive.messages.updateChat');
        Route::get('/messages/searchUsers', [ChatsActivityController::class, 'searchUsers'])->name('erp.executive.messages.searchUsers');
        Route::post('/messages/messageReply/{id}', [ChatsActivityController::class, 'messageReply'])->name('erp.executive.messages.messageReply');
        Route::post('/messages/chatReply/{id}', [ChatsActivityController::class, 'chatReply'])->name('erp.executive.messages.chatReply');
        Route::get('/messages/deleteMessage/{id}',[ChatsActivityController::class, 'deleteMessage'])->name('erp.executive.messages.deleteMessage');
        Route::get('/messages/deleteChatMessage/{id}',[ChatsActivityController::class, 'deleteChatMessage'])->name('erp.executive.messages.deleteChatMessage');
        Route::get('/messages/readMessage/{id}', [ChatsActivityController::class, 'readMessage'])->name('erp.executive.messages.readMessage');
//        Route::get('/messages/update-notifications', [ChatsActivityController::class, 'updateNotifications'])->name('erp.executive.messages.updateNotifications');

        Route::get('/articles', [ArticleController::class, 'index'])->name('erp.executive.articles.index');
        Route::post('/articles/storeArticle', [ArticleController::class, 'storeArticle'])->name('erp.executive.articles.storeArticle');
        Route::get('/articles/showArticle/{id}', [ArticleController::class, 'showArticle'])->name('erp.executive.articles.showArticle');
        Route::put('/articles/addToFavorites/{id}', [ArticleController::class, 'addToFavorites'])->name('erp.executive.articles.addToFavorites');
        Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->name('erp.executive.articles.edit');
        Route::put('/articles/update/{id}', [ArticleController::class, 'updateArticle'])->name('erp.executive.articles.updateArticle');
        Route::get('/messages/deleteFile/{id}',[ArticleController::class, 'deleteFile'])->name('erp.executive.articles.deleteFile');
        Route::get('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('erp.executive.articles.delete');
        Route::get('/articles/search', [ArticleController::class, 'search'])->name('erp.executive.articles.search');
        // Route::match(['get', 'post'], 'laravel-mailbox', [MailboxController::class, 'handle'])->name('erp.executive.emails.getemails');
        // Route::post('laravel-mailbox', [MailboxController::class, 'handle'])->name('erp.executive.emails.getemails');

        // Добавим маршрут для GET-запросов
        // Route::get('laravel-mailbox', [MailboxController::class, 'handle'])->name('erp.executive.emails.getemails');

        // // Добавим маршрут для POST-запросов
        // Route::post('laravel-mailbox', [MailboxController::class, 'handlePost']);



    });



});

// Route::match(['get', 'post'], 'laravel-mailbox', [MailboxController::class, 'handle'])->name('erp.executive.emails.getemails');
Route::post('laravel-mailbox', [MailboxController::class, 'handle']);



// Route::prefix('laravel-mailbox')->group(function () {
//     AppServiceProvider::registerMailboxRoutes();
// });

Route::get('/getClientContactInfo', [ClientBaseController::class, 'getClientContactInfo']);
Route::post('/check-company-exists', [ClientBaseController::class, 'checkCompanyExists']);
Route::post('/check-client-exists', [ClientBaseController::class, 'checkClientExists']);

//Route::get('/update-notifications', [ChatsActivityController::class, 'updateNavbarNotifications']);
//Route::get('/update-private-messages/{id}', [ChatsActivityController::class, 'fetchPrivateChatMessages']);
//Route::get('/update-all-messages', [ChatsActivityController::class, 'fetchAllChatMessages']);
//Route::get('/update-notifications-counts', [ChatsActivityController::class, 'updateChatsNotificationsCounts']);


Route::get('/update-chats-data', [ChatsActivityController::class, 'updateChatsData']);



Route::get('/search-users', [ChatsActivityController::class, 'searchUsers']);






// Route::group(['prefix' => 'erp', 'middleware' => ['auth']], function () {
//     Route::get('/', [AdminController::class, 'index'])->name('admin.index');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/passwordUpdate/{id}', [ProfileController::class, 'passwordUpdate'])->name('profile.passwordUpdate');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
