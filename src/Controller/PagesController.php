<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
	 public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->layout('front_default');
		
		
	}
	public function testpdf($id=null){
		$this->viewBuilder()->layout('default');
		//$this->viewBuilder()->autoLayout('');
		
		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('testpdf', 'default');
		$CakePdf->viewVars($this->viewVars);
		$pdf = $CakePdf->output();
		$pdf = $CakePdf->write(WWW_ROOT . 'uploads' . DS. 'pdf' . DS . 'newsletter.pdf');
    exit;
    echo $id;
		$this->viewBuilder()->options([
			'pdfConfig' => [
				'orientation' => 'portrait',
				'filename' => 'Invoice_' . $id,
				'download' => true
			]
		]);
		//$this->RequestHandler->renderAs($this, 'pdf', ['attachment' => 'filename.pdf','output' => 'F']);
		$this->set('title', 'Heritage Events');
	}	
	public function testcsv(){
		Configure::write('debug','0');
		$this->viewBuilder()->autoLayout('');
		$counter	=	0;	
		$reportingData[$counter]['User']['Id'] = "1";
		$reportingData[$counter]['User']['Name'] = "alex";
		$reportingData[$counter]['User']['Type'] = "Type";
		$counter	=	1;	
		$reportingData[$counter]['User']['Id'] = "1";
		$reportingData[$counter]['User']['Name'] = "alex";
		$reportingData[$counter]['User']['Type'] = "Type";
		$this->set('reportingData',$reportingData);
		$this->render('export');
	}
	public function export()
{
    $data = [
        ['Event Name', 'Customer Name', 'Total Amount','Order Status','Order Date'],
        [ 'Leeds Castle Classical Concert Summer 2018','Mr. Alexander thom','£269.50','Processing','Thursday 22nd March 2018'],
        [ 'Leeds Castle Classical Concert Summer 2018','Mrs. Diana Hadden','£108.00','Processing','Friday 23rd March 2018'],
    ];
    $_serialize = 'data';
print_r($data);exit;
    $this->response->download('my_file.csv'); // <= setting the file name
    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact('data', '_serialize'));
}
	public function index($id=null){
		
		$this->loadModel('Events');
		$this->loadModel('DefaultSettings');
		$setting = $this->DefaultSettings->get(1);
		
		if(!$id){
			$id		=	$this->Events->getUpcomingEventID();
		}
		
		$event = $this->Events->find('all')->where( ['Events.id' =>$id] )
										->contain(['Uploads', 'Tickets', 'Products', 'Programs'])
										->first();
		$this->set(compact('event','setting'));
		if($event){
			$this->set('title', $event->title);
		}else{
			$this->set('title', 'Heritage Events');
		}
		$this->set(compact('event'));
	}	

    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display(...$path)
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}
