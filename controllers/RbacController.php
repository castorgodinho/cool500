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



        // add "admin" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        //add company permissions
        $auth->addChild($admin, $createCompany);
        $auth->addChild($admin, $updateCompany);
        $auth->addChild($admin, $viewCompany);
        $auth->addChild($admin, $indexCompany);
        $auth->addChild($admin, $deleteCompany);
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

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        /* $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author); */

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 1);
        
    }
}