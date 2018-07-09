<?php

namespace App\Modules\dashboard\Http\Controllers\userteam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class usergroupController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => true,
        'refresh'   => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc
    public $alias = [
        'idGroup'       => 'groupid',
        'namaGroup'     => 'groupname',
        'permalink'     => 'permalink',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage' => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'groupname' => ['Group Name', true],
    ];

    var $objectkey = '', $groupname = '', $errorgroupname = '', $optmenu = '';
    var $optarr = [];

    public function ajaxpost()
    {
        $request = \Request::instance()->request->all();

        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'addnew' :
                    $this->_loaddbclass([ 'MasterGroup', 'MasterMenu' ]);

                    $this->groupname = $request['groupname'];
                    if(empty($this->groupname)) { $this->errorgroupname = 'Silahkan masukkan '.$this->aliasform['groupname'][0].' !'; }
                    
                    if(isset($request['optmenu'])) {
                        $this->optmenu = $request['optmenu'];
                        if($this->groupname) {
                            foreach ($this->optmenu as $val) {
                                $arraylist = $this->MasterMenu->getparrent([['idMMenu','=',$val]])->first()->toArray();

                                array_push($this->optarr,$arraylist['idMMenu']);
                                if(is_array($arraylist['_getparrent'])) {
                                    array_push($this->optarr,$arraylist['_getparrent']['idMMenu']);
                                    if(is_array($arraylist['_getparrent']['_getparrent'])) {
                                        array_push($this->optarr,$arraylist['_getparrent']['_getparrent']['idMMenu']);
                                    }
                                }
                            }
                            
                            $this->optarr = array_values(array_unique($this->optarr));
                        }
                    }

                    $MasterGroup = $this->MasterGroup->where([['permalink','=',$this->_permalink($this->groupname)]])->first();

                    if($MasterGroup && $MasterGroup->permalink == $this->_permalink($this->groupname)) {
                        if(!$this->errorgroupname) {
                            $this->errorgroupname = $this->aliasform['groupname'][0].' is already used !!!';
                        }
                    }

                    if(!$this->errorgroupname && isset($request['optmenu'])) {
                        $array  = array(
                            'namaGroup' => $this->groupname,
                            'permalink' => $this->_permalink($this->groupname)
                        );
                        $MasterGroup = $this->MasterGroup->creates($array);

                        $this->_loaddbclass([ 'MasterMenuAccess' ]);

                        $this->MasterMenuAccess->where([['idGroup','=',$MasterGroup->idGroup]])->get()->each(function ($obj) {
                            $obj->delete();
                        });

                        $array = [];
                        foreach($this->optarr as $val) {
                            $array[]  = array(
                                'idMMenu' => $val,
                                'idGroup' => $MasterGroup->idGroup
                            );
                        }

                        $this->_loaddbclass([ 'MasterMenuAccess' ]);

                        $this->MasterMenuAccess->inserts($array);

                        return $MasterGroup->idGroup;
                    }
                break;
                case 'edit' :
                    if(isset($request['idGroup']) && isset($request['optmenu'])) {
                        $this->_loaddbclass([ 'MasterGroup', 'MasterMenu' ]);

                        $this->optmenu = $request['optmenu'];
                        foreach ($this->optmenu as $val) {
                            $arraylist = $this->MasterMenu->getparrent([['idMMenu','=',$val]])->first()->toArray();

                            array_push($this->optarr,$arraylist['idMMenu']);
                            if(is_array($arraylist['_getparrent'])) {
                                array_push($this->optarr,$arraylist['_getparrent']['idMMenu']);
                                if(is_array($arraylist['_getparrent']['_getparrent'])) {
                                    array_push($this->optarr,$arraylist['_getparrent']['_getparrent']['idMMenu']);
                                }
                            }
                        }
                        
                        $this->optarr = array_values(array_unique($this->optarr));

                        $MasterGroup = $this->MasterGroup->where([['idGroup','=',$request['idGroup']]])->first();

                        $this->_loaddbclass(['MasterMenuAccess']);
                        
                        $this->MasterMenuAccess->where([['idGroup','=',$request['idGroup']]])->get()->each(function ($obj) {
                            $obj->delete();
                        });

                        $array = [];
                        foreach($this->optarr as $val) {
                            $array[]  = array(
                                'idMMenu' => $val,
                                'idGroup' => $MasterGroup->idGroup
                            );
                        }

                        $this->_loaddbclass(['MasterMenuAccess']);

                        $this->MasterMenuAccess->inserts($array);
                    }
                break;
                case 'delete' :
                    if (isset($request['delete'])) {
                        $this->_loaddbclass([ 'MasterGroup', 'MasterMenuAccess' ]);

                        $MasterGroup = $this->MasterGroup->where([['idGroup','=',$request['delete']]])->first();
                        if($MasterGroup) {
                            $groupid = $MasterGroup->idGroup;
                            $MasterGroup->delete();

                            $MasterMenuAccess = $this->MasterMenuAccess->where([['idGroup','=',$groupid]])->get();

                            if($MasterMenuAccess) {
                                $MasterMenuAccess->each(function ($obj) {
                                    $obj->delete();
                                });
                            }
                        }
                    }
                break;
            }
        }
    }

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->views();
    }

    public function addnew()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->addnewedit();
    }
    
    public function edit()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->getdata();
    }

    private function getdata() {
        if (isset($this->inv['getid'])) {
            if(!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass([ 'MasterGroup', 'MasterMenuAccess', 'MasterMenu' ]);

                $MasterGroup = $this->MasterGroup->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($MasterGroup) {
                    $groupid            = $MasterGroup[$this->inv['flip']['groupid']];
                    $this->groupname    = $MasterGroup[$this->inv['flip']['groupname']];

                    $MasterMenuAccess   = $this->MasterMenuAccess->where([[$this->inv['flip']['groupid'],'=',$groupid]])->get();

                    $i=0;
                    foreach($MasterMenuAccess as $obj) {
                        $MasterMenu = $this->MasterMenu->where([['idMMenu','=',$obj->idMMenu]])->first();
                        if($MasterMenu) {
                            $this->optmenu[$i] = $MasterMenu->idMMenu;
                            $i++;
                        }
                    }
                } else {
                    $this->inv['messageerror'] = $this->_trans('validation.norecord');
                }
            } else {
                $this->inv['messageerror'] = $this->_trans('validation.norecord');
            }
        }

        return $this->addnewedit();
    }

    private function addnewedit() {
        $request = \Request::instance()->request->all();

        // if(isset($request['optmenu'])) $this->_debugvar(implode(',', $request['optmenu']));
        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([ 'MasterGroup', 'MasterMenu' ]);

            if(isset($request['edit'])) {
                $MasterGroup = $this->MasterGroup->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$MasterGroup) {
                    $this->_redirect('404');
                }
            }

            $this->groupname = $request['groupname'];
            if(empty($this->groupname)) { $this->errorgroupname = 'Silahkan masukkan '.$this->aliasform['groupname'][0].' !'; }
            
            if(!isset($request['optmenu'])) {
                $this->inv['messageerror'] = 'Silahkan pilih akses menu !';
            } else {
                $this->optmenu = $request['optmenu'];
                if($this->groupname) {
                    foreach ($this->optmenu as $val) {
                        $arraylist = $this->MasterMenu->getparrent([['idMMenu','=',$val]])->first()->toArray();

                        array_push($this->optarr,$arraylist['idMMenu']);
                        if(is_array($arraylist['_getparrent'])) {
                            array_push($this->optarr,$arraylist['_getparrent']['idMMenu']);
                            if(is_array($arraylist['_getparrent']['_getparrent'])) {
                                array_push($this->optarr,$arraylist['_getparrent']['_getparrent']['idMMenu']);
                            }
                        }
                    }
                    
                    $this->optarr = array_values(array_unique($this->optarr));
                }
            }

            $MasterGroup = $this->MasterGroup->where([['permalink','=',$this->_permalink($this->groupname)]])->first();

            if($MasterGroup) {
                if(isset($request['addnew']) && $MasterGroup->permalink == $this->_permalink($this->groupname)) {
                    if(!$this->errorgroupname) {
                        $this->errorgroupname = $this->aliasform['groupname'][0].' is already used !!!';
                    }
                } else {
                    if ($MasterGroup[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorgroupname) {
                            $this->errorgroupname = $this->aliasform['groupname'][0].' is already used !!!';
                        }
                    }
                }
            }

            if(!$this->inv['messageerror'] && !$this->errorgroupname) {
                $this->_loaddbclass([ 'MasterMenuAccess' ]);

                if(isset($request['addnew'])) {
                    $array  = array(
                        $this->inv['flip']['groupname'] => $this->groupname,
                        'permalink' => $this->_permalink($this->groupname)
                    );
                    $MasterGroup = $this->MasterGroup->creates($array);

                    $array = [];
                    foreach($this->optarr as $val) {
                        $array[]  = array(
                            'idMMenu' => $val,
                            $this->inv['flip']['groupid'] => $MasterGroup[$this->inv['flip']['groupid']]
                        );
                    }
                    $this->MasterMenuAccess->inserts($array);

                    $this->_dblog('addnew', $this, $this->groupname);
                    \Session::put('messagesuccess', "Saving $this->groupname Completed !");
                } else {
                    $MasterGroup = $this->MasterGroup->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $groupid = $MasterGroup[$this->inv['flip']['groupid']];

                    $array = array(
                        $this->inv['flip']['groupname'] => $this->groupname,
                        'permalink' => $this->_permalink($this->groupname)
                    );
                    $MasterGroup->update($array);

                    $MasterMenuAccess = $this->MasterMenuAccess->where([[$this->inv['flip']['groupid'],'=',$groupid]])->get();
                    if($MasterMenuAccess) {
                        $MasterMenuAccess->each(function ($obj) {
                            $obj->delete();
                        });
                    }

                    $array = [];
                    foreach($this->optarr as $val) {
                        $array[]  = array(
                            'idMMenu' => $val,
                            $this->inv['flip']['groupid'] => $groupid
                        );
                    }
                    $this->MasterMenuAccess->inserts($array);

                    $this->_dblog('edit', $this, $this->groupname);
                    \Session::put('messagesuccess', "Update $this->groupname Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $arrmenu        = $this->MasterMenu->getmenu(['idMParrent','=',0])->get()->toArray();
        $arrmenu        = $this->MasterMenu->getmenuextends([$arrmenu]);

        $this->inv['arrmenu']           = $arrmenu;
        $this->inv['groupname']         = $this->groupname;
        $this->inv['errorgroupname']    = $this->errorgroupname;
        $this->inv['optmenu']           = $this->optmenu;
        $this->inv['optarr']            = $this->optarr;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([ 'MasterGroup', 'MasterMenuAccess' ]);

            foreach($this->inv['delete'] as $val) {
                $MasterGroup = $this->MasterGroup->where([[$this->objectkey,'=',$val]])->first();
                if($MasterGroup) {
                    $groupid = $MasterGroup[$this->inv['flip']['groupid']];
                    $this->groupname = $MasterGroup[$this->inv['flip']['groupname']];
                    $MasterGroup->delete();

                    $MasterMenuAccess = $this->MasterMenuAccess->where([[$this->inv['flip']['groupid'],'=',$groupid]])->get();

                    if($MasterMenuAccess) {
                        $MasterMenuAccess->each(function ($obj) {
                            $obj->delete();
                        });
                    }

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->groupname);
                    $this->inv['messagesuccess'] .= "Delete $this->groupname Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'MasterGroup' ]);

        $result = $this->MasterGroup->where([['namaGroup', 'not like', 'Seller %']])
        ->orderBy($this->inv['flip'][$this->inv['getorder']],$this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}