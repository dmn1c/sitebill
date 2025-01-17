<?php

defined('SITEBILL_DOCUMENT_ROOT') or die('Restricted access');

/**
 * Static pages handler fronend
 * @author Abushyk Kostyantyn <abushyk@gmail.com> http://www.sitebill.ru
 */
/* TODO
 * Поставить запреты на вывод служебных страниц через фронт
 */
class page_site extends page_admin {

    function frontend() {
        if (!$this->getConfigValue('apps.page.enable')) {
            return false;
        }

        $REQUESTURIPATH = Sitebill::getClearRequestURI();
        
        if($REQUESTURIPATH == ''){
            return false;
        }

        if (preg_match('/^blog(\/?)$/', $REQUESTURIPATH, $matches) and $this->getConfigValue('apps.page.blog_enable')) {
            $rs = $this->showBlog();
            return true;
        } elseif (preg_match('/^recommendations(\/?)$/', $REQUESTURIPATH, $matches) and $this->getConfigValue('apps.page.recommendations_enable')) {
            //@todo:Надо переопределить ключевое слово recommendations на определение URL топика (И мета инфу для топика получать из топиков новостей, это чтобы не плодить лишних сущностей)
            $rs = $this->showBlogCategory();
            return true;
        } else {
            /* if ( $_SERVER['REQUEST_URI'] == SITEBILL_MAIN_URL.'/' and ($page_array = $this->getPageByURI('index.html')) ) {

              } else {
              $page_array=$this->getPageByURI($REQUESTURIPATH);
              } */
            

            $page_id = $this->getPageIDByURI($REQUESTURIPATH);

            if ($page_id > 0) {



                require_once(SITEBILL_DOCUMENT_ROOT . '/apps/system/lib/model/model.php');
                $data_model = new Data_Model();
                $form_data = $this->data_model;

                $model = $data_model->init_model_data_from_db($this->table_name, $this->primary_key, $page_id, $form_data[$this->table_name]);


                if (1 === intval($this->getConfigValue('apps.language.use_langs'))) {
                    $model = $data_model->init_language_values($model, $model);
                }
                
                
                
                if($form_data[$this->table_name]['body']['parameters']['richtext'] == 1){
                    $text = $model['body']['value'];
                    if(0 < preg_match_all('/(<\!--\$image\s([a-z0-9_]+)\.(\d+)((\|(.+))?)-->)/', $text, $matches)){

                        if(!empty($matches[1])){
                            $replaces = array();
                            foreach($matches[1] as $k=>$pos){
                                $im_fname = $matches[2][$k];
                                $im_index = $matches[3][$k];
                                $params_list = array();
                                $params = trim($matches[4][$k]);
                                if('' != $params){
                                    if(preg_match_all('/\|([a-z_]+)\:([^|]+)/', $params, $m)){
                                        foreach($m[1] as $mk=>$mv){
                                            $params_list[$mv] = $m[2][$mk];
                                        }
                                    }
                                }

                                if(!isset($params_list['caption'])){
                                    $params_list['caption'] = '';
                                }
                                if(!isset($params_list['alt'])){
                                    if($params_list['caption'] != ''){
                                        $params_list['alt'] = $params_list['caption'];
                                    }else{
                                        $params_list['alt'] = $art['title']['value'].' фото '.($im_index+1);
                                    }

                                }
                                if(!isset($params_list['class'])){
                                    $params_list['class'] = $wrapclass;
                                }else{
                                    $params_list['class'] = $wrapclass.' '.$params_list['class'];
                                }
                                if(!isset($params_list['link'])){
                                    $params_list['link'] = '';
                                }else{
                                    if(!preg_match('/^http(s?)/', $params_list['link'])){
                                        $params_list['link'] = $this->createUrlTpl($params_list['link']);
                                    }
                                }
                                if(isset($model[$im_fname]['value'][$im_index])){

                                    $rep = '';
                                    $rep .= '<div class="imbuildimg imbuildimg-page'.(''!=$params_list['class'] ? ' '.$params_list['class'] : '').'">';

                                    if($params_list['link'] != ''){
                                        $rep .= '<a href="'.$params_list['link'].'">';
                                    }

                                    if(1==intval($this->getConfigValue('apps.articles.photo_div'))){
                                        $rep .= '<div class="imbuildimg-image" style="background-image:url(\''.$this->getServerFullUrl().'/img/data/'.$model[$im_fname]['value'][$im_index]['normal'].'\');"></div>';
                                    }else{
                                        $rep .= '<div class="imbuildimg-image"><img src="'.$this->getServerFullUrl().'/img/data/'.$model[$im_fname]['value'][$im_index]['normal'].'"'.($params_list['alt'] != '' ? ' alt="'.$params_list['alt'].'"' : '').'></div>';
                                    }

                                    if($params_list['link'] != ''){
                                        $rep .= '</a>';
                                    }

                                    if($params_list['caption'] != ''){
                                        $rep .= '<div class="imbuildimg-caption">'.$params_list['caption'].'</div>';
                                    }

                                    $rep .= '</div>';

                                    $replaces[$pos] = $rep;


                                }else{
                                    $replaces[$pos]='';
                                }
                            }
                            $model['body']['value'] = str_replace(array_keys($replaces), array_values($replaces), $text);
                        }
                    }
                }
                
                if (preg_match('/roadmap/', $_SERVER['REQUEST_URI'])) {
                    $map_array = $this->getPageByURI('map');
                    $this->template->assert('main', '<div class="apppage_wrapper">' . $model['body']['value'] . $map_array['body'] . '</div>');
                } else {
                    $this->template->assert('main', '<div class="apppage_wrapper">' . $model['body']['value'] . '</div>');
                }

                if (isset($model['template']['value']) && $model['template']['value'] != '') {
                    $tplname = str_replace(array('./', '../'), '', $model['template']['value']);
                    if (file_exists(SITEBILL_DOCUMENT_ROOT . '/template/frontend/' . $this->getConfigValue('theme') . '/' . $tplname)) {
                        global $smarty;
                        $this->template->assert('main', $smarty->fetch(SITEBILL_DOCUMENT_ROOT . '/template/frontend/' . $this->getConfigValue('theme') . '/' . $tplname));
                    }
                }

                $this->template->assert('title', $model['title']['value']);
                $this->template->assert('breadcrumbs', $this->get_breadcrumbs(array('<a href="' . SITEBILL_MAIN_URL . '/">' . Multilanguage::_('L_HOME') . '</a>', $model['title']['value'])));

                $this->template->assert('meta_title', $model['meta_title']['value']);
                $this->template->assert('meta_keywords', $model['meta_keywords']['value']);
                $this->template->assert('meta_description', $model['meta_description']['value']);
                $this->template->assert('apps_page_view', 1);

                //$this->template->render();
                //$rs = $this->template->toHTML();
                return true;
            }

            /* if($page_array){
              if(isset($this->data_model[$this->table_name]['is_service']) && $page_array['is_service']!=0){
              return false;
              }
              if ( preg_match('/roadmap/', $_SERVER['REQUEST_URI']) ) {
              $map_array = $this->getPageByURI('map');
              $this->template->assert('main', '<div class="apppage_wrapper">'.$page_array['body'].$map_array['body'].'</div>');
              } else {
              $this->template->assert('main', '<div class="apppage_wrapper">'.$page_array['body'].'</div>');
              }

              if(isset($page_array['template']) && $page_array['template']!=''){
              $tplname=str_replace(array('./', '../'), '', $page_array['template']);
              if(file_exists(SITEBILL_DOCUMENT_ROOT.'/template/frontend/'.$this->getConfigValue('theme').'/'.$tplname)){
              global $smarty;
              $this->template->assert('main', $smarty->fetch(SITEBILL_DOCUMENT_ROOT.'/template/frontend/'.$this->getConfigValue('theme').'/'.$tplname));
              }
              }

              $this->template->assert('title', $page_array['title']);
              $this->template->assert('breadcrumbs', $this->get_breadcrumbs(array('<a href="'.SITEBILL_MAIN_URL.'/">'.Multilanguage::_('L_HOME').'</a>',$page_array['title'])));

              $this->template->assert('meta_title', $page_array['meta_title']);
              $this->template->assert('meta_keywords', $page_array['meta_keywords']);
              $this->template->assert('meta_description', $page_array['meta_description']);
              $this->template->assert('apps_page_view', 1);

              $this->template->render();
              $rs = $this->template->toHTML();
              return true;
              } */
        }
        return false;
    }

    private function showBlogCategory() {
        if (1 == (int) $this->getConfigValue('apps.seo.no_trailing_slashes')) {
            $trailing_slashe = '';
        } else {
            $trailing_slashe = '/';
        }
        $blogRecords = array();
        $DBC = DBC::getInstance();
        $page = ((int) $this->getRequestValue('page') > 0 ? (int) $this->getRequestValue('page') : 1);
        $per_page = $this->getConfigValue('apps.page.per_page');

        $start = ($page - 1) * $per_page;

        $where = array();
        $where_v = array();

        $where[] = '`topic_id`=?';
        $where_v[] = 1;
        if (isset($this->data_model[$this->table_name]['is_service'])) {
            $where[] = '( `is_service` <> 1 or `is_service` is NULL )';
        }

        $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM ' . DB_PREFIX . '_' . $this->table_name . (!empty($where) ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY ' . $this->primary_key . ' DESC LIMIT ' . $start . ', ' . $per_page;
        $stmt = $DBC->query($query, $where_v);

        $check_lang_fields = false;
        $postfix = '';
        if (1 === intval($this->getConfigValue('apps.language.use_langs'))) {
            $check_lang_fields = true;
            $postfix = $this->getLangPostfix($this->getCurrentLang());
            if($postfix == ''){
                $check_lang_fields = false;
            }
        }

        if ($stmt) {
            while ($ar = $DBC->fetch($stmt)) {
                if ($check_lang_fields) {
                    foreach ($ar as $key => $val) {
                        $lang_key = $key . $postfix;
                        if (isset($ar[$lang_key]) && $ar[$lang_key] != '') {
                            $ar[$key] = $ar[$lang_key];
                        }
                    }
                }


                $ar['href'] = SITEBILL_MAIN_URL . '/' . trim($ar['uri'], '/') . (false !== strpos($ar['uri'], '.') ? '' : $trailing_slashe);
                $fp = strpos($ar['body'], '<p>');
                $lp = strpos($ar['body'], '</p>');
                if ($fp !== false && $lp !== false) {
                    $ar['body'] = strip_tags(mb_substr($ar['body'], $fp, $lp));
                } else {
                    $ar['body'] = mb_substr(strip_tags($ar['body']), 0, 200);
                }
                $blogRecords[] = $ar;
            }
        }



        $total = 0;
        $query = 'SELECT FOUND_ROWS() AS ttl';
        $stmt = $DBC->query($query);
        if ($stmt) {
            $ar = $DBC->fetch($stmt);
            $total = $ar['ttl'];
        }

        if (file_exists(SITEBILL_DOCUMENT_ROOT . '/apps/system/lib/system/view/page_navigator.php')) {
            require_once SITEBILL_DOCUMENT_ROOT . '/apps/system/lib/system/view/page_navigator.php';
            $url = '';
            if (isset($params['pager_url'])) {
                $url = $params['pager_url'];
                unset($params['pager_url']);
            }

            if ($params['admin']) {
                $nurl = 'account/data';
            } else {
                $nurl = $pageurl;
            }
            //print_r($params);


            $paging = Page_Navigator::getPagingArray($total, $page, $per_page, array(), 'blog');

            $this->template->assert('blog_pager_array', $paging);
        } else {
            $pager_params['page_url'] = 'blog';
            $this->template->assert('blog_pager', $this->get_page_links_list($page, $total, $per_page, $pager_params));
        }





        $this->template->assert('title', 'Рекомендации');
        $this->template->assert('meta_title', 'Рекомендации');
        $this->template->assert('blogRecords', $blogRecords);
        $this->set_apps_template('page', $this->getConfigValue('theme'), 'main_file_tpl', 'blog_grid.tpl');
    }

    private function showBlog() {
        if (1 == (int) $this->getConfigValue('apps.seo.no_trailing_slashes')) {
            $trailing_slashe = '';
        } else {
            $trailing_slashe = '/';
        }
        $blogRecords = array();
        $DBC = DBC::getInstance();
        $page = ((int) $this->getRequestValue('page') > 0 ? (int) $this->getRequestValue('page') : 1);
        $per_page = $this->getConfigValue('apps.page.per_page');

        $start = ($page - 1) * $per_page;

        $where = array();
        $where_v = array();
        if (isset($this->data_model[$this->table_name]['is_service'])) {
            $where[] = '( `is_service` <> 1  or `is_service` is NULL )';
        }

        $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM ' . DB_PREFIX . '_' . $this->table_name . (!empty($where) ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY ' . $this->primary_key . ' DESC LIMIT ' . $start . ', ' . $per_page;
        $stmt = $DBC->query($query, $where_v);

        $check_lang_fields = false;
        $postfix = '';
        if (1 === intval($this->getConfigValue('apps.language.use_langs'))) {
            $check_lang_fields = true;
            $postfix = $this->getLangPostfix($this->getCurrentLang());
            if($postfix == ''){
                $check_lang_fields = false;
            }
        }

        if ($stmt) {
            while ($ar = $DBC->fetch($stmt)) {
                if ($check_lang_fields) {
                    foreach ($ar as $key => $val) {
                        $lang_key = $key . $postfix;
                        if (isset($ar[$lang_key]) && $ar[$lang_key] != '') {
                            $ar[$key] = $ar[$lang_key];
                        }
                    }
                }


                $ar['href'] = SITEBILL_MAIN_URL . '/' . trim($ar['uri'], '/') . (false !== strpos($ar['uri'], '.') ? '' : $trailing_slashe);
                $fp = strpos($ar['body'], '<p>');
                $lp = strpos($ar['body'], '</p>');
                if ($fp !== false && $lp !== false) {
                    $ar['body'] = strip_tags(mb_substr($ar['body'], $fp, $lp));
                } else {
                    $ar['body'] = mb_substr(strip_tags($ar['body']), 0, 200);
                }
                $blogRecords[] = $ar;
            }
        }



        $total = 0;
        $query = 'SELECT FOUND_ROWS() AS ttl';
        $stmt = $DBC->query($query);
        if ($stmt) {
            $ar = $DBC->fetch($stmt);
            $total = $ar['ttl'];
        }

        if (file_exists(SITEBILL_DOCUMENT_ROOT . '/apps/system/lib/system/view/page_navigator.php')) {
            require_once SITEBILL_DOCUMENT_ROOT . '/apps/system/lib/system/view/page_navigator.php';
            $url = '';
            if (isset($params['pager_url'])) {
                $url = $params['pager_url'];
                unset($params['pager_url']);
            }

            if ($params['admin']) {
                $nurl = 'account/data';
            } else {
                $nurl = $pageurl;
            }
            //print_r($params);


            $paging = Page_Navigator::getPagingArray($total, $page, $per_page, array(), 'blog');

            $this->template->assert('blog_pager_array', $paging);
        } else {
            $pager_params['page_url'] = 'blog';
            $this->template->assert('blog_pager', $this->get_page_links_list($page, $total, $per_page, $pager_params));
        }

        $this->template->assert('title', 'Блог');
        $this->template->assert('meta_title', 'Блог');
        $this->template->assert('blogRecords', $blogRecords);
        $this->set_apps_template('page', $this->getConfigValue('theme'), 'main_file_tpl', 'blog_grid.tpl');
    }

    function getPageIDByURI($uri) {
        $where = array();
        $where_v = array();
        if (isset($this->data_model[$this->table_name]['is_service'])) {
            $where[] = '( `is_service` <> 1 or `is_service` is NULL )';
        }
        $where[] = '`uri`=?';
        $where_v[] = $uri;
        $query = 'SELECT page_id FROM ' . DB_PREFIX . '_' . $this->table_name . ' WHERE ' . implode(' AND ', $where) . ' LIMIT 1';
        $DBC = DBC::getInstance();
        $stmt = $DBC->query($query, $where_v);
        if ($stmt) {
            $ar = $DBC->fetch($stmt);
            return intval($ar['page_id']);
        }
        return 0;
    }

    function getPageByURI($uri) {
        
        $check_lang_fields = false;
        $postfix = '';
        if (1 === intval($this->getConfigValue('apps.language.use_langs'))) {
            $check_lang_fields = true;
            $postfix = $this->getLangPostfix($this->getCurrentLang());
            if($postfix == ''){
                $check_lang_fields = false;
            }
        }
        
        $where = array();
        $where_v = array();
        /* if(isset($this->data_model[$this->table_name]['is_service']) && isset($page_array['is_service']) && $page_array['is_service']!=0){
          $where[]='`is_service`=0';
          } */
        $where[] = '`uri`=?';
        $where_v[] = $uri;
        //$uri = mysql_real_escape_string($uri);
        $query = 'SELECT * FROM ' . DB_PREFIX . '_' . $this->table_name . ' WHERE ' . implode(' AND ', $where) . ' LIMIT 1';
        $DBC = DBC::getInstance();
        $stmt = $DBC->query($query, array($uri));
        if ($stmt) {
            $ar = $DBC->fetch($stmt);
            
            if($check_lang_fields){
                foreach ($ar as $key => $item_array) {
                    $lang_key = $key . $postfix;
                    if(isset($ar[$lang_key])){
                        if (1 === intval($this->getConfigValue('apps.language.fulltransmode'))) {
                            $ar[$key] = $ar[$lang_key];
                        }elseif ($ar[$lang_key] != '') {
                            $ar[$key] = $ar[$lang_key];
                        }
                    }
                }
            }
            
            if ((int) $ar['page_id'] > 0) {
                return $ar;
            }
        }
        return 0;
    }

}
