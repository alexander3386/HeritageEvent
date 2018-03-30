<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $settings
 */
class SettingsController extends AppController
{
	    /**
	     * Initialization hook method.
	     *
	     * Use this method to add common initialization code like loading components.
	     *
	     * @return void
	     */
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->layout('admin');
	}
    
	    /**
	     * defaultSettings method
	     *
	     * @param string|null $id Default Settings id.
	     * @return \Cake\Network\Response|void Redirects on successful submit, renders view otherwise.
	     * @throws \Cake\Network\Exception\NotFoundException When record not found.
	     */
	public function defaultSettings($id = 1)
	{ 
		$setting_id	=	$id;
		$this->loadModel('DefaultSettings');
		$setting = $this->DefaultSettings->newEntity();
		if(!empty($id)){
			$setting = $this->DefaultSettings->get($id);
		}
		if ($this->request->is(['patch', 'post', 'put'])) {
			$setting = $this->DefaultSettings->patchEntity($setting, $this->request->data);
			if ($this->DefaultSettings->save($setting)) {
				$this->Flash->success(__('The settings has been saved.'));
				return $this->redirect(['action' => 'defaultsettings',1]);
			} else {
				$errorMessages = [];
				$errors = $setting->errors();
				array_walk_recursive($errors, function($a) use (&$errorMessages) { $errorMessages[] = $a; });
				$this->Flash->error(__("The settings could not be saved. Please, try again."),['params' => ['errors' => $errorMessages]]);
			}
		}
		$this->set('title', 'Settings');
		$this->set(compact('setting','setting_id'));
		$this->set('_serialize', ['setting']);
	}
 }