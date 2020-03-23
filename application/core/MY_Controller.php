<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $auth   = true;
    protected $layout = 'template';
    protected $now;
    protected $rules;

    protected $page_title;

    public $ci;
    public $limit = 10;

    public $_user_login;
    public $_created;
    public $_updated;
    public $_deleted;

    public function _remap($method, $params = array())
    {
        if ($this->auth) {
            $this->load->model('menu_model');
            $this->load->model('privilege_model');

            $level      = $this->session->userdata('level');
            $class_name = get_class($this);

            $menu = $this->menu_model->first(
                array(
                    'controller' => $class_name,
                )
            );
            if (!empty($menu)) {
                $privilege = $this->privilege_model->first(
                    array(
                        'id_level' => $level,
                        'id_menu'  => $menu->id,
                    )
                );
                if (!is_null($privilege)) {
                    if ($privilege->view == 1) {
                        $this->rules[$level][] = 'index';
                        $this->rules[$level][] = 'lists';
                        $this->rules[$level][] = 'get_data';
                        $this->rules[$level][] = 'report';
                    }
                    if ($privilege->create == 1) {
                        $this->_created        = 1;
                        $this->rules[$level][] = 'add';
                    }
                    if ($privilege->update == 1) {
                        $this->_updated = 1;
                        if (!empty($params)) {
                            $this->rules[$level][] = 'edit';
                        }
                    }
                    if ($privilege->delete == 1) {
                        $this->_deleted        = 1;
                        $this->rules[$level][] = 'delete';
                    }
                }
            }
            if (!isset($this->rules[$level])) {
                $this->rules[$level] = array();
            }
            $rules = $this->rules[$level];
            if (!empty($rules)) {
                if (in_array($method, $rules)) {
                    if (method_exists($this, $method)) {
                        return call_user_func_array(array($this, $method), $params);
                    }
                    show_404();
                    return;
                }
            }
            $data['message'] = 'You have no privilege to access it!';
            $this->render('error', $data);
        } else {
            if (method_exists($this, $method)) {
                return call_user_func_array(array($this, $method), $params);
            }

            show_404();
            return;
        }
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model');
        $this->load->model('privilege_model');
        $this->load->model('user_model');

        $this->now = date('Y-m-d H:i:s');
        $this->ci  = &get_instance();

        $this->_user_login = $this->user_model->first(
            array('id' => $this->session->userdata('id_user'))
        );
    }

    public function check_validation($level_logged = 'dashboard')
    {
        if (!is_null($level_logged)) {
            $level  = $this->session->userdata('level');
            $status = $this->session->userdata('status');

            if (!is_null($level) && !is_null($status)) {
                if ($status != '1') {
                    //Check active or not
                    $this->session->set_flashdata('message', array('message' => 'Your account not active..', 'class' => 'alert-info'));
                    redirect('login');
                }

                $redirect = 'dashboard';

                if ($redirect != $level_logged) {
                    $this->session->set_flashdata('message', array('message' => 'You don\'t allowed to access..', 'class' => 'alert-info'));
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('message', array('message' => 'You must login to continue..', 'class' => 'alert-info'));
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('message', array('message' => 'You must login to continue..', 'class' => 'alert-info'));
            redirect('login');
        }
    }

    public function render($page, $data = null)
    {
        $reflect    = new ReflectionClass($this);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $prop) {
            $data[$prop->name] = $this->{$prop->name};
        }
        $data['_main_content'] = $this->load->view($this->layout . '/' . $page, $data, true);
        $this->load->view($this->layout . '/layout', $data);
        // $this->output->enable_profiler(true);
    }

    public function parent_menu()
    {
        $sql = "SELECT id, title, url, icon, `order`, controller FROM (SELECT menu.id, menu.title, menu.url, menu.icon, menu.order, menu.controller FROM menu WHERE menu.url like '%#%' UNION SELECT menu.id, menu.title, menu.url, menu.icon, menu.order, menu.controller FROM menu JOIN privilege ON menu.id = privilege.id_menu WHERE privilege.id_level = {$this->session->userdata('level')} AND privilege.view = 1 AND menu.id_parent = 0) result ORDER BY `order` ASC";
        return $this->db->query($sql)->result();
    }

    public function has_child_menu($id)
    {
        $child_menu = $this->menu_model->all(
            array(
                'fields'   => 'menu.*, privilege.view',
                'join'     => array('privilege' => 'privilege.id_menu = menu.id'),
                'where'    => array(
                    'privilege.id_level' => $this->session->userdata('level'),
                    'privilege.view'     => 1,
                    'menu.id_parent'     => $id,
                ),
                'order_by' => 'menu.order asc',
            )
        );
        if ($child_menu) {
            return $child_menu;
        } else {
            return null;
        }
    }
}
