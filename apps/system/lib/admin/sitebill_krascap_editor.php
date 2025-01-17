<?php
require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/sitebill_krascap_admin.php');
class SiteBill_Rent_Editor extends SiteBill_Krascap_Admin {
    /**
     * Constructor
     */
    function SiteBill_Rent_Editor() {
        $this->SiteBill_Krascap_Admin();

    }

    /**
     * Main
     * @param void
     * @return string
     */
   /* function main () {
        if ( $_REQUEST['tid'] == '' ) {
            $_REQUEST['tid'] = 2;
        }
        $do = $this->getRequestValue('do');
        $data_array = $this->initDataFromRequest();

        switch ( $do ) {
            case 'edit_done':
                if ( !$this->checkData( $data_array ) ) {
                    $rs = $this->getForm( $data_array );
                    return $rs;
                } else {
                    $this->editRecord( $data_array );
                    $rs = $this->getGridFrame();
                    return $rs;
                    //$rs = $this->getTopMenu();
                    //$rs .= $this->grid();
                }
            break;

            case 'mass_delete':
                $rs = $this->massDelete($_REQUEST['row']);
                $rs .= $this->getGridFrame();
                return $rs;
            break;

            case 'delete':
                $this->deleteRecord( $_REQUEST['id'] );
                $rs = $this->getGridFrame();
                return $rs;
            break;

            case 'new_done':
                if ( !$this->checkData( $data_array ) ) {
                    $rs = $this->getForm( $data_array, 'new_done' );
                    return $rs;
                } else {
                    $this->newRecord( $data_array );
                    $rs = $this->getGridFrame();
                    return $rs;
                }
            break;

            case 'new':
                $rs = $this->getForm( $data_array, 'new_done' );
                return $rs;
            break;
        }

        $data_array = $this->loadRecord($this->getRequestValue('id'));
        $rs = $this->getForm( $data_array );
        return $rs;
    }*/

    /**
     * Get not active adv count
     * @param void
     * @return string
     */
    function getNotActiveAdvCount() {
        $query = "select count(id) as cid from ".DB_PREFIX."_data where active=0";
        $DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
		if($stmt){
			$ar=$DBC->fetch($stmt);
			return $ar['cid'];
		}
		return 0;
    }

    /**
     * Get active count by tid
     * @param int $tid tid
     * @return int
     */
    /*function getActiveTidCount( $tid ) {
        $where_array = false;
        $where_array[] = 're_district.id=re_data.district_id';
        if ( $tid != '' ) {
            $where_array[] = DB_PREFIX.'_data.topic_id='.$tid;
        }

        $where_array[] = DB_PREFIX.'_data.active=1';

        if ( $where_array ) {
            $where_statement = " where ".implode(' and ', $where_array);
        }
        $query = "select count(".DB_PREFIX."_data.id) as cid from ".DB_PREFIX."_data, ".DB_PREFIX."_district $where_statement order by date_added desc";
        $DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
		if($stmt){
			$ar=$DBC->fetch($stmt);
			return $ar['cid'];
		}
        return 0;
    }*/

    /**
     * Get rent order count
     * @param void
     * @return string
     */
    /*function getRentOrderCount() {
        global $__db_prefix;

        $query = "select count(data_get_rent_id) as cid from ".DB_PREFIX."_data_get_rent";
        $DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
        if($stmt){
			$ar=$DBC->fetch($stmt);
			return $ar['cid'];
		}
        return 0;
    }*/

    /**
     * Return array with menu items for rabota.sitebill.ru
     * @param void
     * @return array
     */
    function getRabotaAdminMenu () {
        $menu['vacancy']['title'] = Multilanguage::_('L_ADMIN_MENU_VACANCIES');
        $menu['vacancy']['href'] = 'index.php?action=vacancy';
        if ( $_REQUEST['action'] == 'vacancy' ) {
            $menu['vacancy']['active'] = 1;
        }

        $menu['structure']['title'] = Multilanguage::_('L_ADMIN_MENU_SPECSPHERES');
        $menu['structure']['href'] = 'index.php?action=structure';
        if ( $_REQUEST['action'] == 'structure' ) {
            $menu['structure']['active'] = 1;
        }

            $menu_sub1['country']['title'] = Multilanguage::_('L_ADMIN_MENU_COUNTRIES');
            $menu_sub1['country']['href'] = 'index.php?action=country';
            if ( $_REQUEST['action'] == 'country' ) {
                $menu_sub1['country']['active'] = 1;
            }





            $menu_sub1['region']['title'] = Multilanguage::_('L_ADMIN_MENU_REGIONS');
            $menu_sub1['region']['href'] = 'index.php?action=region';
            if ( $_REQUEST['action'] == 'region' ) {
                $menu_sub1['region']['active'] = 1;
            }

            $menu_sub1['city']['title'] = Multilanguage::_('L_ADMIN_MENU_CITIES');
            $menu_sub1['city']['href'] = 'index.php?action=city';
            if ( $_REQUEST['action'] == 'city' ) {
                $menu_sub1['city']['active'] = 1;
            }

            $menu_sub1['district']['title'] = Multilanguage::_('L_ADMIN_MENU_DISTRICTS');
            $menu_sub1['district']['href'] = 'index.php?action=district';
            if ( $_REQUEST['action'] == 'district' ) {
                $menu_sub1['district']['active'] = 1;
            }

            $menu_sub1['metro']['title'] = Multilanguage::_('L_ADMIN_MENU_METRO');
            $menu_sub1['metro']['href'] = 'index.php?action=metro';
            if ( $_REQUEST['action'] == 'metro' ) {
                $menu_sub1['metro']['active'] = 1;
            }

            $menu_sub1['street']['title'] = Multilanguage::_('L_ADMIN_MENU_STREETS');
            $menu_sub1['street']['href'] = 'index.php?action=street';
            if ( $_REQUEST['action'] == 'street' ) {
                $menu_sub1['street']['active'] = 1;
            }
        $menu['references']['title'] = Multilanguage::_('L_ADMIN_MENU_REFERENCES');
        $menu['references']['href'] = 'index.php?action=country';
        $menu['references']['childs'] = $menu_sub1;
        if ( $_REQUEST['action'] == 'references' ) {
            $menu['references']['active'] = 1;
        }
        $menu_sub3['news']['title'] = Multilanguage::_('L_ADMIN_MENU_NEWS');
        $menu_sub3['news']['href'] = 'index.php?action=news';
        if ( $_REQUEST['action'] == 'news' ) {
            $menu_sub3['news']['active'] = 1;
        }

        $menu_sub3['page']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu_sub3['page']['href'] = 'index.php?action=page';
        if ( $_REQUEST['action'] == 'page' ) {
            $menu_sub3['page']['active'] = 1;
        }

        $menu['content']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu['content']['href'] = 'index.php?action=page';
        $menu['content']['childs'] = $menu_sub3;
        if ( $_REQUEST['action'] == 'content' ) {
            $menu['content']['active'] = 1;
        }

        $menu['user']['title'] = Multilanguage::_('L_ADMIN_MENU_USERS');
        $menu['user']['href'] = 'index.php?action=user';
        if ( $_REQUEST['action'] == 'user' ) {
            $menu['user']['active'] = 1;
        }

        $menu['menu']['title'] = Multilanguage::_('L_ADMIN_MENU_MENUS');
        $menu['menu']['href'] = 'index.php?action=menu';
        if ( $_REQUEST['action'] == 'menu' ) {
            $menu['menu']['active'] = 1;
        }

        require_once (SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/system/apps/apps_processor.php');
        $apps_processor = new Apps_Processor();
        $menu['apps']['title'] = Multilanguage::_('L_ADMIN_MENU_APPLICATIONS');
        $menu['apps']['href'] = 'index.php?action=apps';
        $menu['apps']['childs'] = $apps_processor->load_apps_menu();
        if ( $_REQUEST['action'] == 'apps' ) {
            $menu['apps']['active'] = 1;
        }

        $menu['config']['title'] = Multilanguage::_('L_ADMIN_MENU_SETTINGS');
        $menu['config']['href'] = 'index.php?action=config';
        if ( $_REQUEST['action'] == 'config' ) {
            $menu['config']['active'] = 1;
        }

        $menu['updater']['title'] = Multilanguage::_('L_ADMIN_MENU_UPDATES');
        $menu['updater']['href'] = 'index.php?action=updater';
        if ( $_REQUEST['action'] == 'updater' ) {
            $menu['updater']['active'] = 1;
        }

        $menu['site']['title'] = Multilanguage::_('L_ADMIN_MENU_GOTOSITE');
        $menu['site']['href'] = SITEBILL_MAIN_URL.'/';
        $menu['site']['target'] = '_blank';
        if ( $_REQUEST['action'] == 'site' ) {
            $menu['site']['active'] = 1;
        }



        return $this->compile_menu($menu);
    }

    /**
     * Return array with menu items for orders.sitebill.ru
     * @param void
     * @return array
     */
    function getOrdersAdminMenu () {
        $menu['zapros']['title'] = Multilanguage::_('L_ADMIN_MENU_DEMANDS');
        $menu['zapros']['href'] = 'index.php?action=zapros';
        if ( $_REQUEST['action'] == 'zapros' ) {
            $menu['zapros']['active'] = 1;
        }
        $menu_sub3['news']['title'] = Multilanguage::_('L_ADMIN_MENU_NEWS');
        $menu_sub3['news']['href'] = 'index.php?action=news';
        if ( $_REQUEST['action'] == 'news' ) {
            $menu_sub3['news']['active'] = 1;
        }

        $menu_sub3['page']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu_sub3['page']['href'] = 'index.php?action=page';
        if ( $_REQUEST['action'] == 'page' ) {
            $menu_sub3['page']['active'] = 1;
        }

        $menu['content']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu['content']['href'] = 'index.php?action=page';
        $menu['content']['childs'] = $menu_sub3;
        if ( $_REQUEST['action'] == 'content' ) {
            $menu['content']['active'] = 1;
        }

        $menu['user']['title'] = Multilanguage::_('L_ADMIN_MENU_USERS');
        $menu['user']['href'] = 'index.php?action=user';
        if ( $_REQUEST['action'] == 'user' ) {
            $menu['user']['active'] = 1;
        }

        $menu['menu']['title'] = Multilanguage::_('L_ADMIN_MENU_MENUS');
        $menu['menu']['href'] = 'index.php?action=menu';
        if ( $_REQUEST['action'] == 'menu' ) {
            $menu['menu']['active'] = 1;
        }

            $menu_sub1['country']['title'] = Multilanguage::_('L_ADMIN_MENU_COUNTRIES');
            $menu_sub1['country']['href'] = 'index.php?action=country';
            if ( $_REQUEST['action'] == 'country' ) {
                $menu_sub1['country']['active'] = 1;
            }

            $menu_sub1['region']['title'] = Multilanguage::_('L_ADMIN_MENU_REGIONS');
            $menu_sub1['region']['href'] = 'index.php?action=region';
            if ( $_REQUEST['action'] == 'region' ) {
                $menu_sub1['region']['active'] = 1;
            }

            $menu_sub1['city']['title'] = Multilanguage::_('L_ADMIN_MENU_CITIES');
            $menu_sub1['city']['href'] = 'index.php?action=city';
            if ( $_REQUEST['action'] == 'city' ) {
                $menu_sub1['city']['active'] = 1;
            }

            $menu_sub1['district']['title'] = Multilanguage::_('L_ADMIN_MENU_DISTRICTS');
            $menu_sub1['district']['href'] = 'index.php?action=district';
            if ( $_REQUEST['action'] == 'district' ) {
                $menu_sub1['district']['active'] = 1;
            }

            $menu_sub1['metro']['title'] = Multilanguage::_('L_ADMIN_MENU_METRO');
            $menu_sub1['metro']['href'] = 'index.php?action=metro';
            if ( $_REQUEST['action'] == 'metro' ) {
                $menu_sub1['metro']['active'] = 1;
            }

            $menu_sub1['street']['title'] = Multilanguage::_('L_ADMIN_MENU_STREETS');
            $menu_sub1['street']['href'] = 'index.php?action=street';
            if ( $_REQUEST['action'] == 'street' ) {
                $menu_sub1['street']['active'] = 1;
            }

        $menu['references']['title'] = Multilanguage::_('L_ADMIN_MENU_REFERENCES');
        $menu['references']['href'] = 'index.php?action=country';
        $menu['references']['childs'] = $menu_sub1;
        if ( $_REQUEST['action'] == 'references' ) {
            $menu['references']['active'] = 1;
        }

        $menu['config']['title'] = Multilanguage::_('L_ADMIN_MENU_SETTINGS');
        $menu['config']['href'] = 'index.php?action=config';
        if ( $_REQUEST['action'] == 'config' ) {
            $menu['config']['active'] = 1;
        }

        $menu['updater']['title'] = Multilanguage::_('L_ADMIN_MENU_UPDATES');
        $menu['updater']['href'] = 'index.php?action=updater';
        if ( $_REQUEST['action'] == 'updater' ) {
            $menu['updater']['active'] = 1;
        }

        $menu['site']['title'] = Multilanguage::_('L_ADMIN_MENU_GOTOSITE');
        $menu['site']['href'] = SITEBILL_MAIN_URL.'/';
        $menu['site']['target'] = '_blank';
        if ( $_REQUEST['action'] == 'site' ) {
            $menu['site']['active'] = 1;
        }



        return $this->compile_menu($menu);
    }


    /**
     * Return array with menu items for shop.sitebill.ru
     * @param void
     * @return array
     */
    function getShopAdminMenu () {
    	//$menu['product']['title'] = 'Товары';
    	//$MD=Multilanguage::getInstance();
    	$menu['product']['title'] = Multilanguage::_('L_ADMIN_MENU_PRODUCTS');
        $menu['product']['href'] = 'index.php?action=product';
        if ( $_REQUEST['action'] == 'product' ) {
           $menu['product']['active'] = 1;
        }

    	$menu['shop_order']['title'] = Multilanguage::_('L_ADMIN_MENU_ORDERS');
        $menu['shop_order']['href'] = 'index.php?action=shop_order';
        if ( $_REQUEST['action'] == 'shop_order' ) {
           $menu['shop_order']['active'] = 1;
        }

        $menu_sub1['city']['title'] = Multilanguage::_('L_ADMIN_MENU_CITIES');
        $menu_sub1['city']['href'] = 'index.php?action=city';
        if ( $_REQUEST['action'] == 'city' ) {
        	$menu_sub1['city']['active'] = 1;
        }

        $menu['structure']['title'] = Multilanguage::_('L_ADMIN_MENU_CATEGORIES');
        $menu['structure']['href'] = 'index.php?action=structure';
        if ( $_REQUEST['action'] == 'structure' ) {
            $menu['structure']['active'] = 1;
        }

        $menu_sub3['news']['title'] = Multilanguage::_('L_ADMIN_MENU_NEWS');
        $menu_sub3['news']['href'] = 'index.php?action=news';
        if ( $_REQUEST['action'] == 'news' ) {
            $menu_sub3['news']['active'] = 1;
        }

        $menu_sub3['page']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu_sub3['page']['href'] = 'index.php?action=page';
        if ( $_REQUEST['action'] == 'page' ) {
            $menu_sub3['page']['active'] = 1;
        }

        $menu['content']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu['content']['href'] = 'index.php?action=page';
        $menu['content']['childs'] = $menu_sub3;
        if ( $_REQUEST['action'] == 'content' ) {
            $menu['content']['active'] = 1;
        }

        $menu['references']['title'] = Multilanguage::_('L_ADMIN_MENU_REFERENCES');
        $menu['references']['href'] = 'index.php?action=country';
        $menu['references']['childs'] = $menu_sub1;
        if ( $_REQUEST['action'] == 'references' ) {
        	$menu['references']['active'] = 1;
        }


        $menu['user']['title'] = Multilanguage::_('L_ADMIN_MENU_USERS');
        $menu['user']['href'] = 'index.php?action=user';
        if ( $_REQUEST['action'] == 'user' ) {
            $menu['user']['active'] = 1;
        }

        $menu_sub_group['component']['title'] = Multilanguage::_('L_ADMIN_MENU_COMPONENTS');
        $menu_sub_group['component']['href'] = 'index.php?action=component';
        if ( $_REQUEST['action'] == 'component' ) {
            $menu_sub_group['component']['active'] = 1;
        }

        $menu_sub_group['function']['title'] = Multilanguage::_('L_ADMIN_MENU_FUNCTIONS');
        $menu_sub_group['function']['href'] = 'index.php?action=function';
        if ( $_REQUEST['action'] == 'function' ) {
            $menu_sub_group['function']['active'] = 1;
        }

        $menu['group']['title'] = Multilanguage::_('L_ADMIN_MENU_GROUPS');
        $menu['group']['href'] = 'index.php?action=group';
        $menu['group']['childs'] = $menu_sub_group;
        if ( $_REQUEST['action'] == 'group' ) {
            $menu['group']['active'] = 1;
        }


        $menu['menu']['title'] = Multilanguage::_('L_ADMIN_MENU_MENUS');
        $menu['menu']['href'] = 'index.php?action=menu';
        if ( $_REQUEST['action'] == 'menu' ) {
            $menu['menu']['active'] = 1;
        }

        require_once (SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/system/apps/apps_processor.php');
        $apps_processor = new Apps_Processor();
        $menu['apps']['title'] = Multilanguage::_('L_ADMIN_MENU_APPLICATIONS');
        $menu['apps']['href'] = 'index.php?action=apps';
        $menu['apps']['childs'] = $apps_processor->load_apps_menu();
        if ( $_REQUEST['action'] == 'apps' ) {
            $menu['apps']['active'] = 1;
        }

        $menu['config']['title'] = Multilanguage::_('L_ADMIN_MENU_SETTINGS');
        $menu['config']['href'] = 'index.php?action=config';
        if ( $_REQUEST['action'] == 'config' ) {
            $menu['config']['active'] = 1;
        }

        $menu['updater']['title'] = Multilanguage::_('L_ADMIN_MENU_UPDATES');
        $menu['updater']['href'] = 'index.php?action=updater';
        if ( $_REQUEST['action'] == 'updater' ) {
            $menu['updater']['active'] = 1;
        }

        $menu['site']['title'] = Multilanguage::_('L_ADMIN_MENU_GOTOSITE');
        $menu['site']['href'] = SITEBILL_MAIN_URL.'/';
        $menu['site']['target'] = '_blank';
        if ( $_REQUEST['action'] == 'site' ) {
            $menu['site']['active'] = 1;
        }



        return $this->compile_menu($menu);
    }

    /**
     * Return array with menu items for shop.sitebill.ru
     * @param void
     * @return array
     */
    function getSitebillAdminMenu () {
        require_once (SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/system/apps/apps_processor.php');
        $apps_processor = new Apps_Processor();
        $menu['structure']['title'] = Multilanguage::_('L_ADMIN_MENU_CATEGORIES');
        $menu['structure']['href'] = 'index.php?action=structure';
        if ( $_REQUEST['action'] == 'structure' ) {
            $menu['structure']['active'] = 1;
        }

        $menu_sub3['news']['title'] = Multilanguage::_('L_ADMIN_MENU_NEWS');
        $menu_sub3['news']['href'] = 'index.php?action=news';
        if ( $_REQUEST['action'] == 'news' ) {
            $menu_sub3['news']['active'] = 1;
        }

        $menu_sub3['page']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu_sub3['page']['href'] = 'index.php?action=page';
        if ( $_REQUEST['action'] == 'page' ) {
            $menu_sub3['page']['active'] = 1;
        }

        $menu['content']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu['content']['href'] = 'index.php?action=page';
        $menu['content']['childs'] = $menu_sub3;
        if ( $_REQUEST['action'] == 'content' ) {
            $menu['content']['active'] = 1;
        }

        $menu['user']['title'] = Multilanguage::_('L_ADMIN_MENU_USERS');
        $menu['user']['href'] = 'index.php?action=user';
        if ( $_REQUEST['action'] == 'user' ) {
            $menu['user']['active'] = 1;
        }

        $menu['menu']['title'] = Multilanguage::_('L_ADMIN_MENU_MENUS');
        $menu['menu']['href'] = 'index.php?action=menu';
        if ( $_REQUEST['action'] == 'menu' ) {
            $menu['menu']['active'] = 1;
        }

        $menu['apps']['title'] = Multilanguage::_('L_ADMIN_MENU_APPLICATIONS');
        $menu['apps']['href'] = 'index.php?action=apps';
        $menu['apps']['childs'] = $apps_processor->load_apps_menu();
        if ( $_REQUEST['action'] == 'apps' ) {
            $menu['apps']['active'] = 1;
        }

        $menu['config']['title'] = Multilanguage::_('L_ADMIN_MENU_SETTINGS');
        $menu['config']['href'] = 'index.php?action=config';
        if ( $_REQUEST['action'] == 'config' ) {
            $menu['config']['active'] = 1;
        }

        $menu['updater']['title'] = Multilanguage::_('L_ADMIN_MENU_UPDATES');
        $menu['updater']['href'] = 'index.php?action=updater';
        if ( $_REQUEST['action'] == 'updater' ) {
            $menu['updater']['active'] = 1;
        }

        $menu['site']['title'] = Multilanguage::_('L_ADMIN_MENU_GOTOSITE');
        $menu['site']['href'] = SITEBILL_MAIN_URL.'/';
        $menu['site']['target'] = '_blank';
        if ( $_REQUEST['action'] == 'site' ) {
            $menu['site']['active'] = 1;
        }



        return $this->compile_menu($menu);
    }

    /**
     * Compile dropdown menu from array
     * @param array $menu
     * @return string
     */
    function compile_menu ( $menu ) {
        foreach ( $menu as $menu_key => $menu_item ) {
            $menu_string .= '<li><a class="mainlevel-son-of-suckerfish-horizontal" href="'.$menu_item['href'].'" target="'.$menu_item['target'].'"><span>'.$menu_item['title'].'</span></a>';
            if ( is_array($menu_item['childs'])  ) {
                //print_r($menu_item['childs']);
                $menu_string .= '<ul id="menulist_10-son-of-suckerfish-horizontal"><li class="submenu_top"></li>';
                foreach ( $menu_item['childs'] as $child_id => $child_array ) {
                    $menu_string .= '<li><a href="'.$child_array['href'].'" class="sublevel-son-of-suckerfish-horizontal"><span>'.$child_array['title'].'</span></a> </li>';
                }
                $menu_string .= '<li class="submenu_bottom"></li>';
                $menu_string .= '</ul>';
            }
            $menu_string .= '</li>';
        }

        return $menu_string;
    }

    /**
     * Get admin menu
     * @param void
     * @return string
     */
    function getAdminMenu () {

        $menu=$this->getAdminMenuArray();


        require_once (SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/system/permission/permission.php');
        $permission = new Permission();

        $menu_string='';
        //echo $_SESSION['user_id_value'].'<br>';
        foreach ( $menu as $menu_key => $menu_item ) {

        	if ( !$permission->get_access($_SESSION['user_id_value'], $menu_key, 'access') and $this->getConfigValue('check_permissions') ) {
        		//echo 'access deny '.$menu_key.'<br>';
        		continue;
        	}

            $menu_string .= '<li><a class="mainlevel-son-of-suckerfish-horizontal" href="'.$menu_item['href'].'" target="'.(isset($menu_item['target']) ? $menu_item['target'] : '').'"><span>'.$menu_item['title'].'</span></a>';
            if ( isset($menu_item['childs']) AND is_array($menu_item['childs'])  ) {
                //print_r($menu_item['childs']);
                $menu_string .= '<ul id="menulist_10-son-of-suckerfish-horizontal"><li class="submenu_top"></li>';
                foreach ( $menu_item['childs'] as $child_id => $child_array ) {
                	//echo "insert into re_component (name) values ('{$child_id}');<br>";

                	if ( !$permission->get_access($_SESSION['user_id_value'], $child_id, 'access') and $this->getConfigValue('check_permissions') ) {
                		continue;
                	}

                    $menu_string .= '<li><a href="'.$child_array['href'].'" class="sublevel-son-of-suckerfish-horizontal"><span>'.$child_array['title'].'</span></a> </li>';
                }
                $menu_string .= '<li class="submenu_bottom"></li>';
                $menu_string .= '</ul>';
            }
            $menu_string .= '</li>';
        }

        return $menu_string;
    }

    /**
     * Get admin menu
     * @param void
     * @return string
     */
    function getSimpleAdminMenu () {
        $menu_sub3['news']['title'] = Multilanguage::_('L_ADMIN_MENU_NEWS');
        $menu_sub3['news']['href'] = 'index.php?action=news';
        if ( $_REQUEST['action'] == 'news' ) {
            $menu_sub3['news']['active'] = 1;
        }

        $menu_sub3['page']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu_sub3['page']['href'] = 'index.php?action=page';
        if ( $_REQUEST['action'] == 'page' ) {
            $menu_sub3['page']['active'] = 1;
        }


        $menu['content']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu['content']['href'] = 'index.php?action=page';
        $menu['content']['childs'] = $menu_sub3;
        if ( $_REQUEST['action'] == 'content' ) {
            $menu['content']['active'] = 1;
        }


        $menu['users']['title'] = Multilanguage::_('L_ADMIN_MENU_USERS');
        $menu['users']['href'] = 'index.php?action=users';
        if ( $_REQUEST['action'] == 'users' ) {
            $menu['users']['active'] = 1;
        }

        require_once (SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/system/apps/apps_processor.php');
        $apps_processor = new Apps_Processor();
        $menu['apps']['title'] = Multilanguage::_('L_ADMIN_MENU_APPLICATIONS');
        $menu['apps']['href'] = 'index.php?action=apps';
        $menu['apps']['childs'] = $apps_processor->load_apps_menu();
        if ( $_REQUEST['action'] == 'apps' ) {
            $menu['apps']['active'] = 1;
        }

        $menu['config']['title'] = Multilanguage::_('L_ADMIN_MENU_SETTINGS');
        $menu['config']['href'] = 'index.php?action=config';
        if ( $_REQUEST['action'] == 'config' ) {
            $menu['config']['active'] = 1;
        }

        $menu['updater']['title'] = Multilanguage::_('L_ADMIN_MENU_UPDATES');
        $menu['updater']['href'] = 'index.php?action=updater';
        if ( $_REQUEST['action'] == 'updater' ) {
            $menu['updater']['active'] = 1;
        }

        $menu['site']['title'] = Multilanguage::_('L_ADMIN_MENU_GOTOSITE');
        $menu['site']['href'] = SITEBILL_MAIN_URL.'/';
        $menu['site']['target'] = '_blank';
        if ( $_REQUEST['action'] == 'site' ) {
            $menu['site']['active'] = 1;
        }

        foreach ( $menu as $menu_key => $menu_item ) {
            $menu_string .= '<li><a class="mainlevel-son-of-suckerfish-horizontal" href="'.$menu_item['href'].'" target="'.$menu_item['target'].'"><span>'.$menu_item['title'].'</span></a>';
            if ( count($menu_item['childs']) > 0  ) {
                //print_r($menu_item['childs']);
                $menu_string .= '<ul id="menulist_10-son-of-suckerfish-horizontal"><li class="submenu_top"></li>';
                foreach ( $menu_item['childs'] as $child_id => $child_array ) {
                    $menu_string .= '<li><a href="'.$child_array['href'].'" class="sublevel-son-of-suckerfish-horizontal"><span>'.$child_array['title'].'</span></a> </li>';
                }
                $menu_string .= '<li class="submenu_bottom"></li>';
                $menu_string .= '</ul>';
            }
            $menu_string .= '</li>';
        }

        return $menu_string;
    }


    public function getAdminMenuArray($admin_path = 'admin'){
        $menu = array();

        //$topics_print = "<li><a href='index.php?action=adv_moderator'>Объявления для модерации (".$this->getNotActiveAdvCount().")</a></li>\n";
        //$topics_print .= "<li><a href='reqlist.php'><b>Заявки</b></a></li>\n";
        /*
         $menu['land']['title'] = 'Участки (pro)';
        $menu['land']['href'] = 'index.php?action=land';
        */

        $menu['data']['title'] = Multilanguage::_('L_ADMIN_MENU_AUTOADVERTS');
        $menu['data']['href'] = 'index.php?action=data';
        $menu['data']['icon'] = 'fa fa-book';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'data') ) {
            $menu['data']['active'] = 1;
        }



        $menu_sub4['data']['title'] = Multilanguage::_('L_ADMIN_MENU_ESTATEDATA');
        $menu_sub4['data']['href'] = 'index.php?action=data';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'data') ) {
            $menu_sub4['data']['active'] = 1;
        }

        require_once SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/data/data_manager.php';
        $DM=new Data_Manager();

        require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/model/model.php');
        $data_model = new Data_Model();
        $model = $data_model->get_kvartira_model(false, true);
        $statuses=array();
        if(isset($model['data']['status_id'])){
            if($model['data']['status_id']['type']=='select_box'){
                foreach($model['data']['status_id']['select_data'] as $k=>$v){
                    $statuses[$k]=$v;
                }
            }
        }

        /*$statuses2=array();
        if(isset($model['data']['optype'])){
            if($model['data']['optype']['type']=='select_box'){
                foreach($model['data']['optype']['select_data'] as $k=>$v){
                    $statuses2[$k]=$v;
                }
            }
        }*/

        $stat_params=array();
        if(!empty($statuses)){
            $stat_params[]='status_id';
        }
        /*if(!empty($statuses2)){
            $stat_params[]='optype';
        }*/

        $stat=$DM->getDataStatInfo($stat_params);

        $menu_sub5['sdata_1']['title'] = 'Все ('.intval($stat['total']).')';
        $menu_sub5['sdata_1']['href'] = SITEBILL_MAIN_URL.'/admin?action=data';

        if(!empty($statuses)){
            foreach($statuses as $k=>$v){
                $menu_sub5[]=array('title'=>$v.' ('.intval($stat['status']['status_id'][$k]).')', 'href'=>SITEBILL_MAIN_URL.'/admin?action=data&status_id='.$k);
            }
        }

        /*if(!empty($statuses2)){
            foreach($statuses2 as $k=>$v){
                $menu_sub5[]=array('title'=>$v.' ('.intval($stat['status']['optype'][$k]).')', 'href'=>SITEBILL_MAIN_URL.'/admin/?action=data&optype='.$k);
            }
        }*/

        /*
        $menu_sub5['sdata_1']['title'] = 'Актуальные ('.intval($stat['status'][1]).')';
        $menu_sub5['sdata_1']['href'] = SITEBILL_MAIN_URL.'/admin/?action=data&status_id=1';

        $menu_sub5['sdata_2']['title'] = 'На прозвон ('.intval($stat['status'][2]).')';
        $menu_sub5['sdata_2']['href'] = SITEBILL_MAIN_URL.'/admin/?action=data&status_id=2';

        $menu_sub5['sdata_3']['title'] = 'Не дозвонились ('.intval($stat['status'][3]).')';
        $menu_sub5['sdata_3']['href'] = SITEBILL_MAIN_URL.'/admin/?action=data&status_id=3';
        */
        $menu_sub5['sdata_4']['title'] = 'Модерация ('.intval($stat['active'][0]).')';
        $menu_sub5['sdata_4']['href'] = SITEBILL_MAIN_URL.'/admin?action=data&active=notactive';

        if(file_exists(SITEBILL_DOCUMENT_ROOT.'/apps/realtylogv2/admin/admin.php') && $this->getConfigValue('apps.realtylogv2.enable')==1){
            require_once SITEBILL_DOCUMENT_ROOT.'/apps/realtylogv2/admin/admin.php';
            $RL=new realtylogv2_admin();

            $menu_sub5['sdata_5']['title'] = 'Архив ('.$RL->getDeletedCount().')';
            $menu_sub5['sdata_5']['href'] = SITEBILL_MAIN_URL.'/admin?action=realtylogv2';
        }

        $menu_sub5['sdata_6']['title'] = 'Активные ('.intval($stat['active'][1]).')';
        $menu_sub5['sdata_6']['href'] = SITEBILL_MAIN_URL.'/admin?action=data&active=1';

        $menu_sub5['sdata_7']['title'] = 'Неактивные ('.intval($stat['active'][0]).')';
        $menu_sub5['sdata_7']['href'] = SITEBILL_MAIN_URL.'/admin?action=data&active=notactive';

        $menu_sub4['data']['childs'] = $menu_sub5;


    	$menu_sub4['structure']['title'] = Multilanguage::_('L_ADMIN_MENU_STRUCTURE');
    	$menu_sub4['structure']['href'] = 'index.php?action=structure';
    	if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'structure') ) {
    		$menu_sub4['structure']['active'] = 1;
    	}

    	$menu['datamain']['title'] = Multilanguage::_('L_ADMIN_MENU_ADVERTS');
    	$menu['datamain']['href'] = 'index.php?action=data';
    	$menu['datamain']['childs'] = $menu_sub4;
        $menu['datamain']['icon'] = 'fa fa-book';

    	if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'datamain') ) {
    		$menu['datamain']['active'] = 1;
    	}

    	$menu['client']['title'] = Multilanguage::_('L_CLIENT_MENU');
    	$menu['client']['href'] = 'index.php?action=client';
        $menu['client']['icon'] = 'icon-ace-icon fa fa-heart bigger-125';

    	if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'client') ) {
    		$menu['client']['active'] = 1;
    	}

        $menu['references']['title'] = Multilanguage::_('L_ADMIN_MENU_REFERENCES');
        $menu['references']['href'] = 'index.php?action=country';
        $menu['references']['icon'] = 'icon-globe';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'references') ) {
            $menu['references']['active'] = 1;
        }
        $menu_sub1['country']['title'] = Multilanguage::_('L_ADMIN_MENU_COUNTRIES');
        $menu_sub1['country']['href'] = 'index.php?action=country';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'country') ) {
            $menu['references']['active'] = 1;
            $menu_sub1['country']['active'] = 1;
        }

        $menu_sub1['region']['title'] = Multilanguage::_('L_ADMIN_MENU_REGIONS');
        $menu_sub1['region']['href'] = 'index.php?action=region';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'region') ) {
            $menu['references']['active'] = 1;
            $menu_sub1['region']['active'] = 1;
        }

        $menu_sub1['city']['title'] = Multilanguage::_('L_ADMIN_MENU_CITIES');
        $menu_sub1['city']['href'] = 'index.php?action=city';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'city') ) {
            $menu['references']['active'] = 1;
            $menu_sub1['city']['active'] = 1;
        }

        $menu_sub1['district']['title'] = Multilanguage::_('L_ADMIN_MENU_DISTRICTS');
        $menu_sub1['district']['href'] = 'index.php?action=district';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'district') ) {
            $menu['references']['active'] = 1;
            $menu_sub1['district']['active'] = 1;
        }

        $menu_sub1['metro']['title'] = Multilanguage::_('L_ADMIN_MENU_METRO');
        $menu_sub1['metro']['href'] = 'index.php?action=metro';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'metro') ) {
            $menu['references']['active'] = 1;
            $menu_sub1['metro']['active'] = 1;
        }

        $menu_sub1['street']['title'] = Multilanguage::_('L_ADMIN_MENU_STREETS');
        $menu_sub1['street']['href'] = 'index.php?action=street';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'street') ) {
            $menu['references']['active'] = 1;
            $menu_sub1['street']['active'] = 1;
        }
        $menu['references']['childs'] = $menu_sub1;



        $menu['content']['title'] = Multilanguage::_('L_CONTENT_MENU');
        $menu['content']['href'] = 'index.php?action=page';
        $menu['content']['icon'] = 'icon-coffee';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'content') ) {
            $menu['content']['active'] = 1;
        }
        $menu_sub3['news']['title'] = Multilanguage::_('L_ADMIN_MENU_NEWS');
        $menu_sub3['news']['href'] = 'index.php?action=news';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'news') ) {
            $menu_sub3['news']['active'] = 1;
            $menu['content']['active'] = 1;
        }

        $menu_sub3['page']['title'] = Multilanguage::_('L_ADMIN_MENU_PAGES');
        $menu_sub3['page']['href'] = 'index.php?action=page';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'page') ) {
            $menu_sub3['page']['active'] = 1;
            $menu['content']['active'] = 1;
        }

        $menu_sub3['menu']['title'] = Multilanguage::_('L_ADMIN_MENU_MENUS');
        $menu_sub3['menu']['href'] = 'index.php?action=menu';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'menu') ) {
            $menu_sub3['menu']['active'] = 1;
            $menu['content']['active'] = 1;
        }
        $menu['content']['childs'] = $menu_sub3;



        $menu['config']['title'] = Multilanguage::_('L_ADMIN_MENU_SETTINGS');
        $menu['config']['href'] = 'index.php?action=config';
        $menu['config']['icon'] = 'icon-cog';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'config') ) {
            $menu['config']['active'] = 1;
        }

        $menu['sitebill']['title'] = Multilanguage::_('L_ADMIN_MENU_UPDATES');
        $menu['sitebill']['href'] = 'index.php?action=sitebill';
        $menu['sitebill']['icon'] = 'fa fa-sync';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'sitebill') ) {
            $menu['sitebill']['active'] = 1;
        }

        $menu['user']['title'] = Multilanguage::_('L_ADMIN_MENU_USERS');
        $menu['user']['href'] = 'index.php?action=user';
        $menu['user']['icon'] = 'icon-user';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'user') ) {
            $menu['user']['active'] = 1;
        }

        $menu['structure']['title'] = Multilanguage::_('L_ADMIN_MENU_STRUCTURE');
        $menu['structure']['href'] = 'index.php?action=structure';
        $menu['structure']['icon'] = 'icon-th-list';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'structure') ) {
            $menu['structure']['active'] = 1;
        }

        $menu['table']['title'] = Multilanguage::_('L_TABLE_MENU');
        $menu['table']['href'] = 'index.php?action=table';
        $menu['table']['icon'] = 'fa fa-edit';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'table') ) {
            $menu['table']['active'] = 1;
        }

        $menu_sub_group['group']['title'] = Multilanguage::_('L_ADMIN_MENU_GROUPS');
        $menu_sub_group['group']['href'] = 'index.php?action=group';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'group') ) {
            $menu_sub_group['group']['active'] = 1;
            $menu['access']['active'] = 1;
        }

        $menu_sub_group['component']['title'] = Multilanguage::_('L_ADMIN_MENU_COMPONENTS');
        $menu_sub_group['component']['href'] = 'index.php?action=component';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'component') ) {
            $menu_sub_group['component']['active'] = 1;
            $menu['access']['active'] = 1;
        }

        $menu_sub_group['function']['title'] = Multilanguage::_('L_ADMIN_MENU_FUNCTIONS');
        $menu_sub_group['function']['href'] = 'index.php?action=function';
        if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'function') ) {
            $menu_sub_group['function']['active'] = 1;
            $menu['access']['active'] = 1;
        }

        $menu['access']['title'] = Multilanguage::_('L_ADMIN_MENU_ACCESS');
        $menu['access']['href'] = '';
        $menu['access']['childs'] = $menu_sub_group;
        $menu['access']['icon'] = 'fa fa-group';




        /*Компоненты*/


        $menu_sub101=array();
        if(1==$this->getConfigValue('enable_curator_mode')){
            $menu_sub101['cowork']['title'] = 'Куратор';
            $menu_sub101['cowork']['href'] = 'index.php?action=cowork';
            if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'cowork') ) {
                $menu['components']['cowork'] = 1;
                //$menu_sub101['cowork']['active'] = 1;
            }
        }

        if(!empty($menu_sub101)){
            $menu['components']['title'] = 'Компонент';
            $menu['components']['href'] = '#';

            if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'components') ) {
                $menu['components']['active'] = 1;
            }

            $menu['components']['childs'] = $menu_sub101;
        }

        $menus_from_db = array();

        if ( class_exists('\menu\api\menu') ) {
            $menu_api = new \menu\api\menu();
            $menus_from_db = $menu_api->load_menus();
            if ( $menus_from_db['admin'] ) {
                $menu = $menus_from_db['admin'];
            }
        }

    	require_once (SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/system/apps/apps_processor.php');
    	$apps_processor = new Apps_Processor();
    	$menu['apps']['title'] = Multilanguage::_('L_ADMIN_MENU_APPLICATIONS');
    	$menu['apps']['href'] = 'index.php?action=apps';
        if ( $menus_from_db['apps'] ) {
            $apps_array = $menus_from_db['apps'];
        } else {
            $apps_array = $apps_processor->load_apps_menu(false, $admin_path);
        }

    	$menu['apps']['childs'] = $apps_array;
    	if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'apps') ) {
    		$menu['apps']['active'] = 1;
    	}

        $menu['nested_apps'] = $this->make_nested_apps_array($apps_array);

    	$menu['site']['title'] = Multilanguage::_('L_ADMIN_MENU_GOTOSITE');
    	$menu['site']['href'] = SITEBILL_MAIN_URL.'/';
    	$menu['site']['target'] = '_blank';
    	if ( isset($_REQUEST['action']) AND ($_REQUEST['action'] == 'site') ) {
    		$menu['site']['active'] = 1;
    	}



    	return $menu;
    }

    private function make_nested_apps_array ($apps_array) {
        $ra = array();
        $uncategorized = array();
        $uncategorizedtitle = 'Прочее';
        $uncategorizedid = 0;
        foreach ($apps_array as $app_name => $item) {
            if ( !empty($item['params']['category']) ) {
                $ra[$item['params']['category']]['title'] = $item['params']['category'];
                $ra[$item['params']['category']]['childs'][$app_name] = $item;
            } else {
                $uncategorized[$app_name] = $item;
            }
        }
        if(!empty($ra) && !empty($uncategorized)){
            $ra[$uncategorizedid]['title'] = $uncategorizedtitle;
            $ra[$uncategorizedid]['childs'] = $uncategorized;
        }
        return $ra;
    }


    /**
     * Mass delete
     * @param array $rows rows
     * @return boolean
     */
    /*function massDelete ( $rows ) {
        if ( count($rows) ) {
        	$DBC=DBC::getInstance();
        	foreach ( $rows as $item_id => $item ) {
                $item_count++;
                $query = 'delete from '.DB_PREFIX.'_data where id='.$item_id;
                $stmt=$DBC->query($query);
            }
        } else {
            $item_count = 0;
        }
        return sprintf(Multilanguage::_('L_MESSAGE_DELETED_N_RECORDS'),$item_count);//'Удалено '.$item_count.' записи(ей)';
    }*/

    /**
     * Delete record
     * @param int $record_id record ID
     * @return boolean
     */
    /*function deleteRecord ( $record_id ) {
    	$DBC=DBC::getInstance();
        $query = 'delete from '.DB_PREFIX.'_data where id=?';
        $stmt=$DBC->query($query, array($record_id));
        return true;
    }*/

    /**
     * Has childs?
     * @param int $tid tid
     * @return boolean
     */
    /*function hasChilds ( $tid ) {
    	$DBC=DBC::getInstance();
        $query = 'select COUNT(id) AS cid from '.DB_PREFIX.'_topic where parent_id=?';
        $stmt=$DBC->query($query, array($tid));
        if($stmt){
        	$ar=$DBC->fetch($stmt);
        	if ( $ar['cid'] > 0 ) {
        		return true;
        	}
        }
        return false;
    }*/

    /**
     * Get first tid1
     * @param int $tid tid
     * @return int
     */
    /*function getFirstTid1 ( $tid ) {
        $query = "select id from re_topic where parent_id=$tid order by `order` limit 1";
        $DBC=DBC::getInstance();
        $stmt=$DBC->query($query);
        if($stmt){
        	$ar=$DBC->fetch($stmt);
	        if ( $ar['id'] > 0 ) {
	            return $ar['id'];
	        }
        }
        return false;
    }*/

    /**
     * Get grid frame
     * @param void
     * @return string
     */
    /*function getGridFrame () {
        if ( $_REQUEST['tid'] == '' ) {
            $_REQUEST['tid'] = 2;
        }

        $rs .= '<table border="0" width="100%">';
        $rs .= '<tr><td colspan="2"><a href="?tid='.$_REQUEST['tid'].'&tid1='.$_REQUEST['tid1'].'&action=sitebill_editor&do=new">'.Multilanguage::_('L_ADD_RECORD_BUTTON').'</a></td></tr>';
        $rs .= '<tr>';
        $rs .= '<td nowrap style="vertical-align: top;">'.$this->getSubTypeFlatList($_REQUEST['tid1'], $_REQUEST['tid']).'<hr>'.$this->getSearchByIDForm().'<br>'.$this->getAdditionalMenu().'</td>';
        $rs .= '<td width="99%"  style="vertical-align: top;">'.$this->grid().'</td>';
        $rs .= '</tr>';
        $rs .= '</table>';
        return $rs;
    }*/

    /**
     * Get additional menu
     * @param void
     * @return string
     */
    function getAdditionalMenu () {
        $rs = '<a href="?action=street">'.Multilanguage::_('L_ADMIN_MENU_STREETS').'</a><br>';
        $rs .= '<a href="?action=district">'.Multilanguage::_('L_ADMIN_MENU_DISTRICTS').'</a><br>';
        return $rs;
    }

    /**
     * Get search by ID form
     * @param void
     * @return string
     */
    /*function getSearchByIDForm () {
        $rs .= '<table border="0" width="100%">';
        $rs .= '<tr>';
        $rs .= '<td style="text-align: center;">';
        $rs .= '<form method="get">';
        $rs .= '<input type="text" name="id" value="">';
        $rs .= '<input type="hidden" name="action" value="sitebill_editor">';
        $rs .= '<input type="hidden" name="do" value="edit">';
        $rs .= '<input type="hidden" name="from" value="search">';
        $rs .= '<input type="submit" value="'.Multilanguage::_('L_SEARCH_BY_ID').'">';
        $rs .= '</form>';
        $rs .= '</td>';
        $rs .= '</tr>';
        $rs .= '</table>';
        return $rs;
    }*/


    /**
     * Grid
     * @param void
     * @return string
     */
    /*function grid () {
        $where_array = false;
        $where_array[] = DB_PREFIX.'_district.id='.DB_PREFIX.'_data.district_id';
        if ( $_REQUEST['tid'] != '' ) {
            $where_array[] = DB_PREFIX.'_data.topic_id='.$_REQUEST['tid'];
        }

        if ( $_REQUEST['tid1'] != '' ) {
            $where_array[] = DB_PREFIX.'_data.type_id='.$_REQUEST['tid1'];
        }
        $moderate = true;
        if ( $moderate ) {
            $where_array[] = DB_PREFIX.'_data.active=1';
        }

        if ( $where_array ) {
            $where_statement = " where ".implode(' and ', $where_array);
        }

        $query = "select ".DB_PREFIX."_data.*, ".DB_PREFIX."_district.name as district from ".DB_PREFIX."_data, ".DB_PREFIX."_district $where_statement order by date_added desc";
        //echo $query;
        $DBC=DBC::getInstance();
        $stmt=$DBC->query($query);
        $rs .= '<form action="index.php" method="post">';
        $grid_rows_head .= '<thead>';
        $grid_rows_head .= '<tr>';
        $grid_rows_head .= '<th class="row_title" width="1%"></th>';
        $grid_rows_head .= '<th class="row_title"></th>';
        $grid_rows_head .= '<th class="row_title">id</th>';
        $grid_rows_head .= '<th class="row_title">Дата добавления&nbsp;&nbsp;&nbsp;&nbsp;</th>';
        $grid_rows_head .= '<th class="row_title">Комнат&nbsp;&nbsp;&nbsp;&nbsp;</th>';
        $grid_rows_head .= '<th class="row_title">Округ</th>';
        $grid_rows_head .= '<th class="row_title">Улица</th>';
        $grid_rows_head .= '<th class="row_title">Цена</th>';
        $grid_rows_head .= '<th class="row_title">Описание</th>';
        $grid_rows_head .= '<th class="row_title">Телефон&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>';
        $grid_rows_head .= '<th class="row_title"></th>';
        $grid_rows_head .= '</tr>';
        $grid_rows_head .= '</thead>';
        $ra = array();
        if($stmt){
        	while ( $ar=$DBC->fetch($stmt) ) {
        		$ra[] = $ar;
        	}
        }

        if(count($ra)>0){
        	foreach ( $ra as $item_id => $item_array ) {
        		$num_rows++;
        		$j++;
        		if ( ceil($j/2) > floor($j/2)  ) {
        			$row_class = "row1";
        		} else {
        			$j = 0;
        			$row_class = "row2";
        		}
        		if ( $item_array['hot'] == 1 ) {
        			$row_class = "hot";
        		}
        		$grid_rows .= '<tr>';

        		$img = $this->getPreviewImage($item_array['id'], 1);
        		if ( !$img ) {
        			$img = '';
        		}

        		$grid_rows .= '<td class="'.$row_class.'"><input type="checkbox" name="row['.$item_array['id'].']" value=""></td>';
        		$grid_rows .= '<td class="'.$row_class.'">'.$img.'</td>';
        		$grid_rows .= '<td class="'.$row_class.'">'.$item_array['id'].'</td>';
        		$grid_rows .= '<td class="'.$row_class.'">'.date('d.m.Y H:i',strtotime($item_array['date_added'])).'</td>';
        		$grid_rows .= '<td class="'.$row_class.'">'.$item_array['room_count'].'</td>';
        		$grid_rows .= '<td class="'.$row_class.'">'.$item_array['district'].'</td>';
        		$grid_rows .= '<td class="'.$row_class.'">'.$item_array['street'].'</td>';
        		$grid_rows .= '<td class="'.$row_class.'">'.$item_array['price'].'</td>';
        		$grid_rows .= '<td class="'.$row_class.'">'.$item_array['text'].'</td>';
        		$grid_rows .= '<td class="'.$row_class.'">'.$item_array['agent_tel'].'</td>';
        		$grid_rows .= '<td class="'.$row_class.'"><a href="?action=sitebill_editor&do=edit&id='.$item_array['id'].'"><img src="'.SITEBILL_MAIN_URL.'/img/edit.gif" border="0"></a><a href="?action=sitebill_editor&do=delete&tid='.$_REQUEST['tid'].'&tid1='.$_REQUEST['tid1'].'&tid2='.$_REQUEST['tid2'].'&id='.$item_array['id'].'" onclick="return confirm(\''.Multilanguage::_('L_MESSAGE_REALLY_WANT_DELETE').'\');"><img src="'.SITEBILL_MAIN_URL.'/img/delete.gif" border="0"></a></td>';
        		$grid_rows .= '</tr>';
        	}
        }


        if ( $num_rows > 0 ) {
            if ( $_REQUEST['tid'] != '' ) {
                $bottom_delete .= '<input type="hidden" name="tid" value="'.$_REQUEST['tid'].'">';
            }
            if ( $_REQUEST['tid1'] != '' ) {
                $bottom_delete .= '<input type="hidden" name="tid1" value="'.$_REQUEST['tid1'].'">';
            }
            if ( $_REQUEST['tid2'] != '' ) {
                $bottom_delete .= '<input type="hidden" name="tid2" value="'.$_REQUEST['tid2'].'">';
            }
            $bottom_delete .= '<input type="hidden" name="action" value="sitebill_editor">';
            $bottom_delete .= '<input type="hidden" name="do" value="mass_delete">';

            $top_delete .= '<tr>';
            $top_delete .= '<td colspan="8"><input type="submit" value="'.Multilanguage::_('L_DELETE_SELECTED_RECORDS').'" onclick="return confirm(\''.Multilanguage::_('L_MESSAGE_REALLY_WANT_DELETE').'\');"></td>';
            $top_delete .= '</tr>';

            $bottom_delete .= '<tr>';
            $bottom_delete .= '<td colspan="11"><input type="submit" value="'.Multilanguage::_('L_DELETE_SELECTED_RECORDS').'" onclick="return confirm(\''.Multilanguage::_('L_MESSAGE_REALLY_WANT_DELETE').'\');"></td>';
            $bottom_delete .= '</tr>';
        }
        $rs .= '<table border="0">';
        $rs .= $top_delete;
        $rs .= '</table>';

        $rs .= '<table class="tablesorter" border="0" width="100%" id="grid" >';
        $rs .= $grid_rows_head;
        $rs .= '<tbody>';
        $rs .= $grid_rows;
        $rs .= '</tbody>';
        $rs .= $bottom_delete;

        $rs .= '</table>';
        $rs .= '</form>';
        return $rs;
    }*/


    /**
     * New record
     * @param array $data_array data array
     * @return string
     */
    /*function newRecord ( $data_array ) {

        if ( $data_array['new_country'] != '' ) {
            require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/country/country_manager.php');
            $country_manager = new Country_Manager();
            $data_array['country_id'] = $country_manager->add_record_and_get_id($data_array['new_country']);
        }

        if ( $data_array['new_city'] != '' ) {
            require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/city/city_manager.php');
            $city_manager = new City_Manager();
            $data_array['city_id'] = $city_manager->add_record_and_get_id($data_array['new_city']);
        }

        if ( $data_array['new_metro'] != '' ) {
            require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/metro/metro_manager.php');
            $metro_manager = new Metro_Manager();
            $data_array['metro_id'] = $metro_manager->add_record_and_get_id($data_array['new_metro']);
        }


        if ( $data_array['new_district'] != '' ) {
            require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/district/district_manager.php');
            $district_manager = new District_Manager();
            $data_array['district_id'] = $district_manager->add_record_and_get_id($data_array['new_district']);
        }
        if ( $data_array['new_street'] != '' ) {

            require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/street/street_manager.php');
            $street_manager = new Street_Manager();
            $data_array['street_id'] = $street_manager->add_record_and_get_id($data_array['new_street']);

            $data_array['street'] = $data_array['new_street'];
        }


        $query = "insert into ".DB_PREFIX."_data set
            type_id='".$data_array['tid1']."',
            topic_id='".$data_array['tid']."',
            country_id='".$data_array['country_id']."',
            city_id='".$data_array['city_id']."',
            metro_id='".$data_array['metro_id']."',
            district_id='".$data_array['district_id']."',
            street='".$data_array['street']."',
            text='".$data_array['text']."',
            price='".$data_array['price']."',
            contact='".$data_array['contact']."',
            agent_tel='".$data_array['agent_tel']."',
            agent_email='".$data_array['agent_email']."',
            room_count='".$data_array['room_count']."',
            elite='".$data_array['elite']."',
            active='".$data_array['active']."',
            hot='".$data_array['hot']."',
            floor='".$data_array['floor']."',
            floor_count='".$data_array['floor_count']."',
            walls='".$data_array['walls']."',
            number='".$data_array['number']."',
            balcony='".$data_array['balcony']."',
            square_all='".$data_array['square_all']."',
            square_live='".$data_array['square_live']."',
            square_kitchen='".$data_array['square_kitchen']."',
            plate='".$data_array['plate']."',
            bathroom='".$data_array['bathroom']."',

            is_telephone='".$data_array['is_telephone']."',
            session_id='',
            furniture='".$data_array['furniture']."'";
        $DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
		if($stmt){
			$record_id = $DBC->lastInsertId();
		}

        if ( !$record_id ) {
            $this->riseError(Multilanguage::_('L_ERROR_ADD_TO_DB'));
            return false;
        }
        $this->editImage($record_id);
        return Multilanguage::_('L_MESSAGE_ADD_SUCCESS');
    }*/

    /**
     * Edit record
     * @param array $data_array data array
     * @return string
     */
    /*function editRecord ( $data_array ) {
        global $sitebill_document_root;

        if ( $data_array['new_country'] != '' ) {
            require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/country/country_manager.php');
            $country_manager = new Country_Manager();
            $data_array['country_id'] = $country_manager->add_record_and_get_id($data_array['new_country']);
        }

        if ( $data_array['new_city'] != '' ) {
            require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/city/city_manager.php');
            $city_manager = new City_Manager();
            $data_array['city_id'] = $city_manager->add_record_and_get_id($data_array['new_city']);
        }

        if ( $data_array['new_metro'] != '' ) {
            require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/metro/metro_manager.php');
            $metro_manager = new Metro_Manager();
            $data_array['metro_id'] = $metro_manager->add_record_and_get_id($data_array['new_metro']);
        }


        if ( $data_array['new_district'] != '' ) {
            require_once(SITEBILL_DOCUMENT_ROOT.'/apps/system/lib/admin/district/district_manager.php');
            $district_manager = new District_Manager();
            $data_array['district_id'] = $district_manager->add_record_and_get_id($data_array['new_district']);
        }
        if ( $data_array['new_street'] != '' ) {
            $data_array['street'] = $data_array['new_street'];
        }

        $query = "update ".DB_PREFIX."_data set
            type_id='".$data_array['tid1']."',
            topic_id='".$data_array['tid']."',
            country_id='".$data_array['country_id']."',
            city_id='".$data_array['city_id']."',
            metro_id='".$data_array['metro_id']."',
            district_id='".$data_array['district_id']."',
            street='".$data_array['street']."',
            text='".$data_array['text']."',
            price='".$data_array['price']."',
            contact='".$data_array['contact']."',
            agent_tel='".$data_array['agent_tel']."',
            agent_email='".$data_array['agent_email']."',
            room_count='".$data_array['room_count']."',
            elite='".$data_array['elite']."',
            active='".$data_array['active']."',
            hot='".$data_array['hot']."',
            floor='".$data_array['floor']."',
            floor_count='".$data_array['floor_count']."',
            walls='".$data_array['walls']."',
            number='".$data_array['number']."',
            balcony='".$data_array['balcony']."',
            square_all='".$data_array['square_all']."',
            square_live='".$data_array['square_live']."',
            square_kitchen='".$data_array['square_kitchen']."',
            plate='".$data_array['plate']."',
            bathroom='".$data_array['bathroom']."',

            is_telephone='".$data_array['is_telephone']."',
            furniture='".$data_array['furniture']."'
        where id=".$data_array['id'];
        //echo $query;
    	$DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
		$this->editImage($data_array['id']);
        return Multilanguage::_('L_MESSAGE_UPDATE_SUCCESS');

    }*/

    /**
     * Check data
     * @param array $data_array data array
     * @return boolean
     */
    /*function checkData ( $data_array ) {
        global $debug_mode;
        if ( $this->getRequestValue('district_id') == '' ) {
            $this->riseError(Multilanguage::_('L_ERROR_DISTRICT_NOT_SPECIFIED'));
            return false;
        }

        if ( $this->getRequestValue('street') == '' ) {
            $this->riseError(Multilanguage::_('L_ERROR_STREET_NOT_SPECIFIED'));
            return false;
        }

        if ( $this->getRequestValue('price') == '' ) {
            $this->riseError(Multilanguage::_('L_ERROR_PRICE_NOT_SPECIFIED'));
            return false;
        }
        return true;
    }*/

    /**
     * Get delete JS function
     * @param void
     * @return string
     */
    /*function getDeleteJsFunction () {
        $rs .= '<script>';
        $rs .= '
function deleteRecord ( record_id ) {
    if ( confirm(\''.Multilanguage::_('L_MESSAGE_REALLY_WANT_DELETE').'\') ) {
        $("#do").val(\'delete\');
        return true;
    }
    return false;
}
</script>
';
        return $rs;
    }*/

    /**
     * Get edit form
     * @param array $data_array data array
     * @param string $do do value
     * @return string
     */
    /*
    function getForm ( $data_array, $do = 'edit_done'  ) {
        $rs .= $this->getUpdateTypesJsFunction();
        $rs .= $this->getDeleteJsFunction();
        $rs .= '<form method="post" action="index.php" enctype="multipart/form-data">';
        $rs .= '<table border="0">';

        $rs .= '<tr>';
        $rs .= '<td colspan="2" style="text-align: center;"><b>'.sprintf(Multilanguage::_('L_MESSAGE_REALLY_WANT_DELETE'),'<span class="error">*</span>').'</b></td>';
        $rs .= '</tr>';

        if ( $this->GetError() ) {
            if ( $this->getRequestValue('from') == 'search' ) {
                return '<span class="error" style="color: red;">'.$this->GetError().'</span>';
            }
            $rs .= '<tr>';
            $rs .= '<td></td>';
            $rs .= '<td><span class="error" style="color: red;">'.$this->GetError().'</span></td>';
            $rs .= '</tr>';
        }

        if ( $data_array['active'] == 1 ) {
            $active_checked = 'checked';
        } else {
            $active_checked = '';
        }
        $rs .= '<tr>';
        $rs .= '<td class="left_column">Публиковать на сайте:</td>';
        $rs .= '<td><input type="checkbox" name="active" value="1" '.$active_checked.'></td>';
        $rs .= '</tr>';


        if ( $data_array['hot'] == 1 ) {
            $hot_checked = 'checked';
        } else {
            $hot_checked = '';
        }
        $rs .= '<tr>';
        $rs .= '<td class="left_column">Спецразмещение:</td>';
        $rs .= '<td><input type="checkbox" name="hot" value="1" '.$hot_checked.'></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Раздел:</td>';
        $rs .= '<td>'.$this->getSubTypeList($data_array['tid'], 0, 'tid').'</td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Тип:</td>';
        $rs .= '<td>'.$this->getSubTypeList($data_array['tid1'], $data_array['tid'], 'tid1').'</td>';
        $rs .= '</tr>';

        if ( $data_array['tid1'] == 0 ) {
            $data_array['tid1'] = false;
        }
        $rs .= '<tr>';
        $rs .= '<td class="left_column">Подтип:</td>';
        $rs .= '<td>'.$this->getSubTypeList($data_array['tid2'], $data_array['tid1'], 'tid2').'</td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Страна<span class="error">*</span>:</td>';
        $rs .= '<td>'.$this->getCountryList($data_array['country_id']).'</td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Новая страна:</td>';
        $rs .= '<td><input type="text" name="new_country" value="'.$data_array['new_country'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Город<span class="error">*</span>:</td>';
        $rs .= '<td>'.$this->getCityList($data_array['city_id']).'</td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Новый город:</td>';
        $rs .= '<td><input type="text" name="new_city" value="'.$data_array['new_city'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Метро:</td>';
        $rs .= '<td>'.$this->getMetroList($data_array['metro_id']).'</td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Новая станция метро:</td>';
        $rs .= '<td><input type="text" name="new_metro" value="'.$data_array['new_metro'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Район<span class="error">*</span>:</td>';
        $rs .= '<td>'.$this->getDistrictList($data_array['district_id']).'</td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Новый район:</td>';
        $rs .= '<td><input type="text" name="new_district" value="'.$data_array['new_district'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Улица<span class="error">*</span>:</td>';
        $rs .= '<td>'.$this->getStreetList($data_array['street']).'</td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Новая улица:</td>';
        $rs .= '<td><input type="text" name="new_street" value="'.$data_array['new_street'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Номер дома:</td>';
        $rs .= '<td><input type="text" name="number" value="'.$data_array['number'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Цена<span class="error">*</span>:</td>';
        $rs .= '<td><input type="text" name="price" value="'.$data_array['price'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Этаж:</td>';
        $rs .= '<td><input type="text" name="floor" value="'.$data_array['floor'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Этажность:</td>';
        $rs .= '<td><input type="text" name="floor_count" value="'.$data_array['floor_count'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Материал стен:</td>';
        $rs .= '<td><input type="text" name="walls" value="'.$data_array['walls'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Балкон:</td>';
        $rs .= '<td><input type="text" name="balcony" value="'.$data_array['balcony'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Площадь общая:</td>';
        $rs .= '<td><input type="text" name="square_all" value="'.$data_array['square_all'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Площадь жилая:</td>';
        $rs .= '<td><input type="text" name="square_live" value="'.$data_array['square_live'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Площадь кухни:</td>';
        $rs .= '<td><input type="text" name="square_kitchen" value="'.$data_array['square_kitchen'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Сан.узел:</td>';
        $rs .= '<td><input type="text" name="bathroom" value="'.$data_array['bathroom'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Плита:</td>';
        $rs .= '<td>'.$this->getPlateList($data_array['plate']).'</td>';
        $rs .= '</tr>';



        $rs .= '<tr>';
        $rs .= '<td class="left_column">Кол.во комнат:</td>';
        $rs .= '<td><input type="text" name="room_count" value="'.$data_array['room_count'].'"></td>';
        $rs .= '</tr>';

        if ( $data_array['elite'] == 1 ) {
            $elite_checked = 'checked';
        } else {
            $elite_checked = '';
        }
        //$rs .= '<tr>';
        //$rs .= '<td class="left_column">Элитное:</td>';
        //$rs .= '<td><input type="checkbox" name="elite" value="1" '.$elite_checked.'></td>';
        //$rs .= '</tr>';


        $rs .= '<tr>';
        $rs .= '<td class="left_column">Описание:</td>';
        $rs .= '<td><textarea name="text" cols="50" rows="7">'.$data_array['text'].'</textarea></td>';
        $rs .= '</tr>';

        if ( $data_array['is_telephone'] == 1 ) {
            $telephone_checked = 'checked';
        } else {
            $telephone_checked = '';
        }

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Телефон:</td>';
        $rs .= '<td><input type="checkbox" name="is_telephone" value="1" '.$telephone_checked.'></td>';
        $rs .= '</tr>';

        if ( $data_array['furniture'] == 1 ) {
            $furniture_checked = 'checked';
        } else {
            $furniture_checked = '';
        }

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Мебель:</td>';
        $rs .= '<td><input type="checkbox" name="furniture" value="1" '.$furniture_checked.'></td>';
        $rs .= '</tr>';

        $rs .= $this->getImageBlock($data_array['id'], 5);

        $rs .= '<tr>';
        $rs .= '<td></td>';
        if ( $this->getRequestValue('action') != '' ) {
            $rs .= '<input type="hidden" name="action" value="'.$this->getRequestValue('action').'">';
        } else {
            $rs .= '<input type="hidden" name="action" value="sitebill_editor">';
        }
        $rs .= '<input type="hidden" id="do" name="do" value="'.$do.'">';
        //$rs .= '<input type="hidden" name="type_id" value="'.$data_array['type_id'].'">';
        if ( $data_array['topic_id'] == '' ) {
            $data_array['topic_id'] = $this->getRequestValue('tid');
        }

        //$rs .= '<input type="hidden" name="topic_id" value="'.$data_array['topic_id'].'">';
        //$rs .= '<input type="hidden" name="sub_id1" value="'.$data_array['sub_id1'].'">';
        //$rs .= '<input type="hidden" name="sub_id2" value="'.$data_array['sub_id2'].'">';
        $rs .= '<input type="hidden" name="id" value="'.$data_array['id'].'">';
        $rs .= '</td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td colspan="2"><hr></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Имя агента:</td>';
        $rs .= '<td><input type="text" name="contact" value="'.$data_array['contact'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Телефон агента:</td>';
        $rs .= '<td><input type="text" name="agent_tel" value="'.$data_array['agent_tel'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td class="left_column">Email агента:</td>';
        $rs .= '<td><input type="text" name="agent_email" value="'.$data_array['agent_email'].'"></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td colspan="2"><hr></td>';
        $rs .= '</tr>';

        $rs .= '<tr>';
        $rs .= '<td><input type="submit" value="Сохранить"></td><td style="text-align: right;"><input type="submit" value="Удалить" onclick="return deleteRecord('.$data_array['id'].')"></td>';
        $rs .= '</tr>';
        $rs .= '</table>';
        $rs .= '</form>';

        return $rs;
    }
    */


    /**
     * Get flat subtype list
     * @param int $type_id type ID
     * @param int $parent_id parent ID
     * @return string
     */
    /*function getSubTypeFlatList ($type_id, $parent_id ) {
        $ra = array();
        if ( $parent_id === false ) {
            $rs = '';
            return $rs;
        }
        $query = "select * from re_topic where parent_id=$parent_id";
        $DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
		if($stmt){
			while ( $ar=$DBC->fetch($stmt) ) {
				$ra[$ar['id']]['name'] = $ar['name'];
			}
		}

        $rs = '<ul id="simple">';
        foreach ( $ra as $id => $ra_array ) {
            if ( $_REQUEST['tid1'] == $id ) {
                $rs .= '<li><b>'.$ra_array['name'].'</b></li>';
            } else {
                $rs .= '<li><a href="?tid='.$_REQUEST['tid'].'&tid1='.$id.'">'.$ra_array['name'].'</a></li>';
            }
            if ( $this->hasChilds( $id ) ) {
                $rs .= $this->getChildList($id);
            }
        }
        $rs .= '</ul>';
        return $rs;
    }*/

    /**
     * Get child list
     * @param int $id id
     * @return string
     */
    /*function getChildList ( $id ) {
        $query = "select * from ".DB_PREFIX."_topic where parent_id=$id order by `order`";
        $DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
		$rs='';
		if($stmt){
			$rs .= '<ul>';
			while ( $ar=$DBC->fetch($stmt) ) {
				if ( $_REQUEST['tid2'] == $ar['id'] ) {
					$rs .= '<li><b>'.$ar['name'].'</b></li>';
				} else {
					$rs .= '<li><a href="?tid='.$_REQUEST['tid'].'&tid1='.$id.'&tid2='.$ar['id'].'">'.$ar['name'].'</a></li>';
				}
			}
			$rs .= '</ul>';
		}
		return $rs;
    }*/



    /**
     * Get type list
     * @param int $type_id type ID
     * @return string
     */
    /*function getTypeList ( $type_id = 2 ) {
        if ( $type_id == '' ) {
            $type_id = 2;
        }
        $query = "select * from ".DB_PREFIX."_type order by id";
        $DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
		$rs='';
		if($stmt){
			$rs = '<select name="type_id">';
        	while ( $ar=$DBC->fetch($stmt) ) {
	            if ( $type_id == $ar['id'] ) {
	                $selected = 'selected';
	            } else {
	                $selected = '';
	            }
	            $rs .= '<option value="'.$ar['id'].'" '.$selected.'>'.$ar['name'].'</option>';
	        }
	        $rs .= '</select>';
		}
        return $rs;
    }*/

    /**
     * Get district list
     * @param int $district_id district ID
     * @return string
     */
    /*function getDistrictList( $district_id ) {
        $query = "select * from ".DB_PREFIX."_district order by id";
        $DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
		$rs='';
		if($stmt){
			$rs = '<select name="district_id">';
			while ( $ar=$DBC->fetch($stmt) ) {
				if ( $type_id == $ar['id'] ) {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				$rs .= '<option value="'.$ar['id'].'" '.$selected.'>'.$ar['name'].'</option>';
			}
			$rs .= '</select>';
		}
        return $rs;
    }*/



    /**
     * Get street list
     * @param string $street street
     * @return string
     */
    /*function getStreetList ( $street ) {
        //echo 'street = '.$street;
        $ra = array();
        $query = "select street_id, name from ".DB_PREFIX."_street order by name";
    	$DBC=DBC::getInstance();
		$stmt=$DBC->query($query);

		if($stmt){
			while ( $ar=$DBC->fetch($stmt) ) {
				$ra[$ar['name']] = $ar['name'];
			}
		}
        $rs = '<select name="street">';
        foreach ( $ra as $key => $value ) {
            if ( $value != '' ) {
                if ( $street == $value ) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $rs .= '<option value="'.$key.'" '.$selected.'>'.$key.'</option>';
            }
        }
        $rs .= '</select>';
        return $rs;
    }*/

    /**
     * Load record
     * @param int $record_id record ID
     * @return array
     */
   /* function loadRecord ( $record_id ) {
        $query = "select * from ".DB_PREFIX."_data where id=$record_id";
        $DBC=DBC::getInstance();
		$stmt=$DBC->query($query);
		if($stmt){
			$ar=$DBC->fetch($stmt);
			if ( $ar['id'] == '' ) {
				$this->riseError(Multilanguage::_('L_ERROR_RECORD_NOT_FOUND'));
				return false;
			}
		}else{
			$this->riseError(Multilanguage::_('L_ERROR_RECORD_NOT_FOUND'));
			return false;
		}

        $ar['tid1'] = $ar['type_id'];
        $ar['tid'] = $ar['topic_id'];
        return $ar;
    }*/
}
