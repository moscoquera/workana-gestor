<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 11/19/17
 * Time: 9:13 AM
 */


namespace App\Traits;

trait NestedRouteBadParameterBug
{
    public function getLastParameter()
    {
        $params = \Route::current()->parameters();
        $lastparam =  array_values($params)[count($params)-1];
        return $lastparam;
    }

    public function edit($id)
    {
        return parent::edit($this->getLastParameter());
    }

    public function view($id)
    {
        return parent::view($this->getLastParameter());
    }

    public function destroy($id)
    {
        return parent::destroy($this->getLastParameter());
    }

    // All the relevant functions of CrudController.php can be added.
}


?>


