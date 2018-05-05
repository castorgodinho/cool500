<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
        // add "Company" permission
        $createCompany = $auth->createPermission('createCompany');
        $createCompany->description = 'Create a Company';
        $auth->add($createCompany);

        $indexCompany = $auth->createPermission('indexCompany');
        $indexCompany->description = 'Index a Company';
        $auth->add($indexCompany);

        $updateCompany = $auth->createPermission('updateCompany');
        $updateCompany->description = 'Update Company';
        $auth->add($updateCompany);

        $viewCompany = $auth->createPermission('viewCompany');
        $updateCompany->description = 'View Company';
        $auth->add($viewCompany);

        $deleteCompany = $auth->createPermission('deleteCompany');
        $deleteCompany->description = 'Delete Company';
        $auth->add($deleteCompany);

        $updateGst = $auth->createPermission('updateGst');
        $updateGst->description = 'Update GST';
        $auth->add($updateGst);

        $uploadReport = $auth->createPermission('uploadReport');
        $uploadReport->description = 'Upload Report file';
        $auth->add($uploadReport);

        $uploadtds = $auth->createPermission('uploadtds');
        $uploadtds->description = 'Upload tds file';
        $auth->add($uploadtds);

        // add "Area" permission
        $createArea = $auth->createPermission('createArea');
        $createArea->description = 'Create a Area';
        $auth->add($createArea);

        $indexArea = $auth->createPermission('indexArea');
        $indexArea->description = 'Index a Area';
        $auth->add($indexArea);

        $updateArea = $auth->createPermission('updateArea');
        $updateArea->description = 'Update Area';
        $auth->add($updateArea);

        $viewArea = $auth->createPermission('viewArea');
        $viewArea->description = 'View Area';
        $auth->add($viewArea);

        $deleteArea = $auth->createPermission('deleteArea');
        $deleteArea->description = 'Delete Area';
        $auth->add($deleteArea);

        // add "Orders" permission
        $createOrders = $auth->createPermission('createOrders');
        $createOrders->description = 'Create a Orders';
        $auth->add($createOrders);

        $indexOrders = $auth->createPermission('indexOrders');
        $indexOrders->description = 'Index a Orders';
        $auth->add($indexOrders);

        $updateOrders = $auth->createPermission('updateOrders');
        $updateOrders->description = 'Update Orders';
        $auth->add($updateOrders);

        $viewOrders = $auth->createPermission('viewOrders');
        $viewOrders->description = 'View Orders';
        $auth->add($viewOrders);

        $deleteOrders = $auth->createPermission('deleteOrder');
        $deleteOrders->description = 'Delete Order';
        $auth->add($deleteOrders);

        // add "Rate" permission
        $createRate = $auth->createPermission('createRate');
        $createRate->description = 'Create a Rate';
        $auth->add($createRate);

        $indexRate = $auth->createPermission('indexRate');
        $indexRate->description = 'Index a Rate';
        $auth->add($indexRate);

        $updateRate = $auth->createPermission('updateRate');
        $updateRate->description = 'Update Rate';
        $auth->add($updateRate);

        $viewRate = $auth->createPermission('viewRate');
        $viewRate->description = 'View Rate';
        $auth->add($viewRate);

        $deleteRate = $auth->createPermission('deleteRate');
        $deleteRate->description = 'Delete Rate';
        $auth->add($deleteRate);

        // add "Plot" permission
        $createPlot = $auth->createPermission('createPlot');
        $createPlot->description = 'Create a Plot';
        $auth->add($createPlot);

        $indexPlot = $auth->createPermission('indexPlot');
        $indexPlot->description = 'Index a Plot';
        $auth->add($indexPlot);

        $updatePlot = $auth->createPermission('updatePlot');
        $updatePlot->description = 'Update Plot';
        $auth->add($updatePlot);

        $viewPlot = $auth->createPermission('viewPlot');
        $viewPlot->description = 'View Plot';
        $auth->add($viewPlot);

        $deletePlot = $auth->createPermission('deletePlot');
        $deletePlot->description = 'Delete Plot';
        $auth->add($deletePlot);

        // add "Site" permission
        $createSite = $auth->createPermission('createSite');
        $createSite->description = 'Create a Site';
        $auth->add($createSite);

        $indexSite = $auth->createPermission('indexSite');
        $indexSite->description = 'Index a Site';
        $auth->add($indexSite);

        $updateSite = $auth->createPermission('updateSite');
        $updateSite->description = 'Update Site';
        $auth->add($updateSite);

        $viewSite = $auth->createPermission('viewSite');
        $viewSite->description = 'View Site';
        $auth->add($viewSite);

        $deleteSite = $auth->createPermission('deleteSite');
        $deleteSite->description = 'Delete Site';
        $auth->add($deleteSite);
        

        // add "Tax" permission
        $createTax = $auth->createPermission('createTax');
        $createTax->description = 'Create a Tax';
        $auth->add($createTax);

        $indexTax = $auth->createPermission('indexTax');
        $indexTax->description = 'Index a Tax';
        $auth->add($indexTax);

        $updateTax = $auth->createPermission('updateTax');
        $updateTax->description = 'Update Tax';
        $auth->add($updateTax);

        $viewTax = $auth->createPermission('viewTax');
        $viewTax->description = 'View Tax';
        $auth->add($viewTax);

        $deleteTax = $auth->createPermission('deleteTax');
        $deleteTax->description = 'Delete Site';
        $auth->add($deleteTax);

        // add "Users" permission
        $createUsers = $auth->createPermission('createUsers');
        $createUsers->description = 'Create a User';
        $auth->add($createUsers);

        $indexUsers = $auth->createPermission('indexUsers');
        $indexUsers->description = 'Index a User';
        $auth->add($indexUsers);

        $updateUsers = $auth->createPermission('updateUsers');
        $updateUsers->description = 'Update User';
        $auth->add($updateUsers);

        $viewUsers = $auth->createPermission('viewUsers');
        $viewUsers->description = 'View User';
        $auth->add($viewUsers);

        $deleteUsers = $auth->createPermission('deleteUsers');
        $deleteUsers->description = 'Delete User';
        $auth->add($deleteUsers);

        $changePassword = $auth->createPermission('changePassword');
        $changePassword->description = 'Delete User';
        $auth->add($changePassword);

        // add "Payment" permission
        $createPayment = $auth->createPermission('createPayment');
        $createPayment->description = 'Create a Payment';
        $auth->add($createPayment);

        $indexPayment = $auth->createPermission('indexPayment');
        $indexPayment->description = 'Index a Payment';
        $auth->add($indexPayment);

        $updatePayment = $auth->createPermission('updatePayment');
        $updatePayment->description = 'Update Payment';
        $auth->add($updatePayment);

        $viewPayment = $auth->createPermission('viewPayment');
        $viewPayment->description = 'View Payment';
        $auth->add($viewPayment);

        $deletePayment = $auth->createPermission('deletePayment');
        $deletePayment->description = 'Delete Payment';
        $auth->add($deletePayment);

        // add "Interest" permission
        $createInterest = $auth->createPermission('createInterest');
        $createInterest->description = 'Create a Interest';
        $auth->add($createInterest);

        $indexInterest = $auth->createPermission('indexInterest');
        $indexInterest->description = 'Index a Interest';
        $auth->add($indexInterest);

        $updateInterest = $auth->createPermission('updateInterest');
        $updateInterest->description = 'Update Interest';
        $auth->add($updateInterest);

        $viewInterest = $auth->createPermission('viewInterest');
        $viewInterest->description = 'View Interest';
        $auth->add($viewInterest);

        $deleteInterest = $auth->createPermission('deleteInterest');
        $deleteInterest->description = 'Delete Interest';
        $auth->add($deleteInterest);

        // add "Invoice" permission
        $createInvoice = $auth->createPermission('createInvoice');
        $createInvoice->description = 'Create a Invoice';
        $auth->add($createInvoice);

        $indexInvoice = $auth->createPermission('indexInvoice');
        $indexInvoice->description = 'Index a Invoice';
        $auth->add($indexInvoice);

        $updateInvoice = $auth->createPermission('updateInvoice');
        $updateInvoice->description = 'Update Invoice';
        $auth->add($updateInvoice);

        $viewInvoice = $auth->createPermission('viewInvoice');
        $viewInvoice->description = 'View Invoice';
        $auth->add($viewInvoice);

        $deleteInvoice = $auth->createPermission('deleteInvoice');
        $deleteInvoice->description = 'Delete Invoice';
        $auth->add($deleteInvoice);

        $searchInvoice = $auth->createPermission('searchInvoice');
        $searchInvoice->description = 'Delete Invoice';
        $auth->add($searchInvoice);


        // add "Report" permission
        $viewInvoiceReport = $auth->createPermission('viewInvoiceReport');
        $viewInvoiceReport->description = 'Create a Report';
        $auth->add($viewInvoiceReport);

        $viewLogReport = $auth->createPermission('viewLogReport');
        $viewLogReport->description = 'View a log Report';
        $auth->add($viewLogReport);

        $viewLedgerReport = $auth->createPermission('viewLedgerReport');
        $viewLedgerReport->description = 'View a ledger Report';
        $auth->add($viewLedgerReport);

        //Log permission
        $createLog = $auth->createPermission('createLog');
        $createLog->description = 'Create Log';
        $auth->add($createLog);

        $updateLog = $auth->createPermission('updateLog');
        $updateLog->description = 'Update Log';
        $auth->add($updateLog);

        $deleteLog = $auth->createPermission('deleteLog');
        $deleteLog->description = 'Delete Log';
        $auth->add($deleteLog);

        // add "admin" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        
        //add company permissions
        $auth->addChild($admin, $createCompany);
        $auth->addChild($admin, $updateCompany);
        $auth->addChild($admin, $viewCompany);
        $auth->addChild($admin, $indexCompany);
        $auth->addChild($admin, $deleteCompany);
        $auth->addChild($admin, $updateGst);
        $auth->addChild($admin, $uploadReport);
        $auth->addChild($admin, $uploadtds);
        //add Area permissions
        $auth->addChild($admin, $createArea);
        $auth->addChild($admin, $updateArea);
        $auth->addChild($admin, $viewArea);
        $auth->addChild($admin, $indexArea);
        $auth->addChild($admin, $deleteArea);
        //add Order permissions
        $auth->addChild($admin, $createOrders);
        $auth->addChild($admin, $updateOrders);
        $auth->addChild($admin, $viewOrders);
        $auth->addChild($admin, $indexOrders);
        $auth->addChild($admin, $deleteOrders);
        //add Plot permissions
        $auth->addChild($admin, $createPlot);
        $auth->addChild($admin, $updatePlot);
        $auth->addChild($admin, $viewPlot);
        $auth->addChild($admin, $indexPlot);
        $auth->addChild($admin, $deletePlot);
        //add Rate permissions
        $auth->addChild($admin, $createRate);
        $auth->addChild($admin, $updateRate);
        $auth->addChild($admin, $viewRate);
        $auth->addChild($admin, $indexRate);
        $auth->addChild($admin, $deleteRate);
        //add Tax permissions
        $auth->addChild($admin, $createTax);
        $auth->addChild($admin, $updateTax);
        $auth->addChild($admin, $viewTax);
        $auth->addChild($admin, $indexTax);
        $auth->addChild($admin, $deleteTax);
        
        //add Site permissions
        $auth->addChild($admin, $createSite);
        $auth->addChild($admin, $updateSite);
        $auth->addChild($admin, $viewSite);
        $auth->addChild($admin, $indexSite);
        $auth->addChild($admin, $deleteSite);
        //add User permissions
        $auth->addChild($admin, $createUsers);
        $auth->addChild($admin, $updateUsers);
        $auth->addChild($admin, $viewUsers);
        $auth->addChild($admin, $indexUsers);
        $auth->addChild($admin, $deleteUsers);
        $auth->addChild($admin, $changePassword);
        //add Invoice permissions
        $auth->addChild($admin, $createInvoice);
        $auth->addChild($admin, $updateInvoice);
        $auth->addChild($admin, $viewInvoice);
        $auth->addChild($admin, $indexInvoice);
        $auth->addChild($admin, $deleteInvoice);
        $auth->addChild($admin, $searchInvoice);
        //add Payment permissions
        $auth->addChild($admin, $createPayment);
        $auth->addChild($admin, $updatePayment);
        $auth->addChild($admin, $viewPayment);
        $auth->addChild($admin, $indexPayment);
        $auth->addChild($admin, $deletePayment);
        //add Payment permissions
        $auth->addChild($admin, $createInterest);
        $auth->addChild($admin, $updateInterest);
        $auth->addChild($admin, $viewInterest);
        $auth->addChild($admin, $indexInterest);
        $auth->addChild($admin, $deleteInterest);
        //add Report Permissions
        $auth->addChild($admin, $viewInvoiceReport);
        $auth->addChild($admin, $viewLedgerReport);
        $auth->addChild($admin, $viewLogReport);
        $auth->addChild($admin, $createLog);
        $auth->addChild($admin, $updateLog);
        $auth->addChild($admin, $deleteLog);

        //Create view own company rule
        $rule = new \app\rbac\CompanyRule;
        $auth->add($rule);
        $viewOwnCompany = $auth->createPermission('viewOwnCompany');
        $viewOwnCompany->description = 'Update own Company';
        $viewOwnCompany->ruleName = $rule->name;
        $auth->add($viewOwnCompany);
        $auth->addChild($viewOwnCompany, $viewCompany);

        //Create view own payment rule
        $rule = new \app\rbac\PaymentRule;
        $auth->add($rule);
        $viewOwnPayment = $auth->createPermission('viewOwnPayment');
        $viewOwnPayment->description = 'View own Payment';
        $viewOwnPayment->ruleName = $rule->name;
        $auth->add($viewOwnPayment);
        $auth->addChild($viewOwnPayment, $viewPayment);

        //Create view own invoice rule
        $rule = new \app\rbac\InvoiceRule;
        $auth->add($rule);
        $viewOwnInvoice = $auth->createPermission('viewOwnInvoice');
        $viewOwnInvoice->description = 'View own Invoice';
        $viewOwnInvoice->ruleName = $rule->name;
        $auth->add($viewOwnInvoice);
        $auth->addChild($viewOwnInvoice, $viewInvoice);

        //update own gst
        $rule = new \app\rbac\GstRule;
        $auth->add($rule);
        $updateOwnGst = $auth->createPermission('updateOwnGst');
        $updateOwnGst->description = 'Update own GST';
        $updateOwnGst->ruleName = $rule->name;
        $auth->add($updateOwnGst);
        $auth->addChild($updateOwnGst, $updateGst);

        //update own gst viewLedgerReport
        $rule = new \app\rbac\TdsRule;
        $auth->add($rule);
        $updateOwntds = $auth->createPermission('updateOwntds');
        $updateOwntds->description = 'Update own TDS';
        $updateOwntds->ruleName = $rule->name;
        $auth->add($updateOwntds);
        $auth->addChild($updateOwntds, $uploadtds);
        
        //view own ledger
        $rule = new \app\rbac\LedgerRule;
        $auth->add($rule);
        $viewOwnLedgerReport = $auth->createPermission('viewOwnLedgerReport');
        $viewOwnLedgerReport->description = 'view own ledger';
        $viewOwnLedgerReport->ruleName = $rule->name;
        $auth->add($viewOwnLedgerReport);
        $auth->addChild($viewOwnLedgerReport, $viewLedgerReport);

        // add "Company" role
        $company = $auth->createRole('company');
        $auth->add($company);
        // add "staff" role
        $staff = $auth->createRole('staff');
        $auth->add($staff);
        // add "staff" role
        $accounts = $auth->createRole('accounts');
        $auth->add($accounts);

        //add company permissions
        $auth->addChild($company, $changePassword);
        $auth->addChild($company, $viewOwnCompany);
        $auth->addChild($company, $viewOwnPayment);
        $auth->addChild($company, $viewOwnInvoice);
        $auth->addChild($company, $updateOwnGst);
        $auth->addChild($company, $updateOwntds);
        $auth->addChild($company, $viewOwnLedgerReport);

        //add Staff permissions
        $auth->addChild($staff, $createCompany);
        $auth->addChild($staff, $viewCompany);
        $auth->addChild($staff, $changePassword);

        //add accounts permissions
        $auth->addChild($accounts, $viewInvoice);
        $auth->addChild($accounts, $createInvoice);
        $auth->addChild($accounts, $indexInvoice);
        $auth->addChild($accounts, $searchInvoice);
        $auth->addChild($accounts, $viewPayment);
        $auth->addChild($accounts, $indexPayment);
        $auth->addChild($accounts, $createPayment);
        $auth->addChild($accounts, $changePassword);
        $auth->addChild($accounts, $viewInvoiceReport);
        $auth->addChild($accounts, $viewLedgerReport);
        $auth->addChild($accounts, $viewLogReport);
        

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        /* $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author); */

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 1);
        $auth->assign($accounts, 30);
        echo 'Success. Roles are successfully created.';
    }
}