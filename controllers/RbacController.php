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

        // add "Tax" permission
        $createTax = $auth->createPermission('createSite');
        $createTax->description = 'Create a Tax';
        $auth->add($createTax);

        $indexTax = $auth->createPermission('indexTax');
        $indexTax->description = 'Index a Tax';
        $auth->add($indexTax);

        $updateSite = $auth->createPermission('updateSite');
        $updateSite->description = 'Update Tax';
        $auth->add($updateSite);

        $viewSite = $auth->createPermission('viewSite');
        $viewSite->description = 'View Tax';
        $auth->add($viewSite);

        // add "Users" permission
        $createUsers = $auth->createPermission('createUsers');
        $createUsers->description = 'Create a Tax';
        $auth->add($createUsers);

        $indexUsers = $auth->createPermission('indexUsers');
        $indexUsers->description = 'Index a Tax';
        $auth->add($indexUsers);

        $updateUsers = $auth->createPermission('updateUsers');
        $updateUsers->description = 'Update Tax';
        $auth->add($updateUsers);

        $viewUsers = $auth->createPermission('viewUsers');
        $viewUsers->description = 'View Tax';
        $auth->add($viewUsers);

        
        // add "updatePost" permission
        $deleteCompany = $auth->createPermission('deleteCompany');
        $deleteCompany->description = 'Delete Company';
        $auth->add($deleteCompany);

        // add "author" role and give this role the "createPost" permission
        $company = $auth->createRole('company');
        $auth->add($company);
        $auth->addChild($company, $updateCompany);
        $auth->addChild($company, $viewCompany);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        /* $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author); */

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($company, 1);
        
    }
}