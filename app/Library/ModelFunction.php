<?php

/*
 * This file is dynamically model | invasma sinar indonesia.
 *
 * (c) Refnaldi Hakim Monintja <refnaldihakim@invasma.com>
 *
 * INVASMA 2016
 */

namespace App\Library;

class ModelFunction extends \App\Library\GlobalFunctionsCall {
	public function _debug($obj) {
		$this->_debugvar($obj->getQuery()->toSql());
	}
	
	public function getmodel() {
		return $this->db->getModel();
	}

	public function inserts($condition = []) {
		return $this->db->getModel()->insert($condition);
	}

	public function creates($condition = []) {
		return $this->db->getModel()->create($condition);
	}
	
	public function first() {
		return $this->db->first();
	}

	public function get() {
		return $this->db->get();
	}
	
	public function join($condition = []) {
		$this->db = $this->db->getModel();
		foreach($condition as $val)
			$this->db = $this->db->join($val[0], $val[1], $val[2], $val[3]);
		return $this->db;
	}
	
	public function leftjoin($condition = []) {
		$this->db = $this->db->getModel();
		foreach($condition as $val)
			$this->db = $this->db->leftjoin($val[0], $val[1], $val[2], $val[3]);
		return $this->db;
	}
	
	public function rightjoin($condition = []) {
		$this->db = $this->db->getModel();
		foreach($condition as $val)
			$this->db = $this->db->rightjoin($val[0], $val[1], $val[2], $val[3]);
		return $this->db;
	}
	
	public function where($condition = []) {
		$this->db = $this->db->getModel();
		foreach($condition as $val)
			$this->db = $this->db->where($val[0], $val[1], $val[2]);
		return $this->db;
	}

	public function orwhere($condition = []) {
		$this->db = $this->db->getModel();
		foreach($condition as $val)
			$this->db = $this->db->orwhere($val[0], $val[1], $val[2]);
		return $this->db;
	}
	
	public function getmenu($condition = []) {
		$this->db = $this->db->getModel();
		if($condition) {
			return $this->db->with(['_child' => function($query) {
				$query->orderBy('priority');
			}])->where($condition[0],$condition[1],$condition[2])->orderBy('priority');
		} else {
			return $this->db->with(['_child' => function($query) {
				$query->orderBy('priority');
			}])->orderBy('priority');
		}
	}
	
	public function getmenuextends($condition = []) {
		$array = array();
		foreach ($condition[0] as $menu) {
			$uusermenuid = $menu['idMMenu'];
			
			$check = 0;
			if(isset($condition[1])) {
				$this->db = $this->db->getModel();
				$tmpdb = $this->db->where($condition[1][0],$condition[1][1],$condition[1][2]);
				$check = $tmpdb->where('idMMenu','=',$uusermenuid)->get()->toArray();
			}
			
			if(count($check) > 0) {
				$tempArr = self::getmenuaksesloop($menu['_child'], $menu['permalink'], $condition);
				if(count($tempArr)) 
					$array[$menu['permalink']] = array (
						'idMMenu'			=> $uusermenuid,
						'idMParrent'		=> $menu['idMParrent'],
						'priority'			=> $menu['priority'],
						'name'				=> $menu['name'],
						'permalink'			=> $menu['permalink'],
						'menu'				=> $menu['menu'],
						'route'				=> $menu['route'],
						'icon'				=> $menu['icon'],
						$menu['permalink']	=> $tempArr,
					);
				else
					$array[$menu['permalink']] = array (
						'idMMenu'		=> $uusermenuid,
						'idMParrent'	=> $menu['idMParrent'],
						'priority'		=> $menu['priority'],
						'name'			=> $menu['name'],
						'permalink'		=> $menu['permalink'],
						'menu'			=> $menu['menu'],
						'route'			=> $menu['route'],
						'icon'			=> $menu['icon'],
					);
			}
		}

        return $array;
	}

	public function getmenuaksesloop($arr, $parent, $condition) {
		$array = array();
		foreach ($arr as $menu) {
			$uusermenuid = $menu['idMMenu'];

			$check = 0;
			if(isset($condition[1])) {
				$this->db = $this->db->getModel();
				$tmpdb = $this->db->where($condition[1][0],$condition[1][1],$condition[1][2]);
				$check = $tmpdb->where('idMMenu','=',$uusermenuid)->get()->toArray();
			}

			if(count($check) > 0) {
				$tempArr = self::getmenuaksesloop($menu['_child'], $menu['permalink'], $condition);
				if(count($tempArr)) 
					$array[] = array (
						'parentName'		=> $parent,
						'idMMenu'			=> $uusermenuid,
						'idMParrent'		=> $menu['idMParrent'],
						'priority'			=> $menu['priority'],
						'name'				=> $menu['name'],
						'permalink'			=> $menu['permalink'],
						'menu'				=> $menu['menu'],
						'route'				=> $menu['route'],
						'icon'				=> $menu['icon'],
						$menu['permalink']	=> $tempArr,
					);
				else
					$array[] = array (
						'parentName'	=> $parent,
						'idMMenu'		=> $uusermenuid,
						'idMParrent'	=> $menu['idMParrent'],
						'priority'		=> $menu['priority'],
						'name'			=> $menu['name'],
						'permalink'		=> $menu['permalink'],
						'menu'			=> $menu['menu'],
						'route'			=> $menu['route'],
						'icon'			=> $menu['icon'],
					);
			}
		}

        return $array;
    }

    public function getaction($condition = []) {
    	$this->db = $this->db->getModel();
		$this->db = $this->db->where($condition[0][0],$condition[0][1],$condition[0][2]);
		$this->db = $this->db->with(['_getaction' => function($query) use ($condition) {
			$query->where($condition[1][0],$condition[1][1],$condition[1][2]);
        }]);

		return $this->db;
	}

	public function getfunction($condition = array()) {
		$this->db = $this->db->getModel();
		$this->db = $this->db->where($condition[0][0],$condition[0][1],$condition[0][2]);
		$this->db = $this->db->with(['_getaction' => function($query) use ($condition) {
			$query->where($condition[1][0],$condition[1][1],$condition[1][2]);
        }]);
		$this->db = $this->db->with(['_getfunction' => function($query) use ($condition) {
			$query->where($condition[2][0],$condition[2][1],$condition[2][2]);
        }]);

        return $this->db;
	}
	
	public function getparrent($condition = array()) {
		$this->db = $this->db->getModel();
		$this->db = $this->db->with(['_getparrent' => function($query) use ($condition) {
			$query->with(['_getparrent']);
		}]);
		
		$this->db = $this->db->where($condition[0][0],$condition[0][1],$condition[0][2]);

        return $this->db;
	}
}