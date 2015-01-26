<?php
/**
 * Implements a basic Controller
 * @package some config
 * http://doc.silverstripe.org/framework/en/3.1/topics/controller
 */
class TourController extends Page_Controller {
	
	private static $url_segment = 'tour';
	
	private static $allowed_actions = array( 
		'index',
                'search',
                'TourSearchForm'
	);
	
	public static $template = 'BlankPage';
	
	/**
	 * Template thats used to render the pages.
	 *
	 * @var string
	 */
	public static $template_main = 'Page';
	
	/**
	 * Initialise the controller
	 */
	public function init() {
		parent::init();
 	}

	/**
	 * Show the "login" page
	 *
	 * @return string Returns the "login" page as HTML code.
	 */
	public function index() {
            $this->redirect('tour/search');
	}

	/**
	 * Show the "login" page
	 *
	 * @return string Returns the "login" page as HTML code.
	 */
	public function search() {
            
            // Vorerst keine Seite erstellt
            $tmpPage = new Page();
            $tmpPage->Title = _t('Tour.SEARCHTITLE', 'Tour.SEARCHTITLE');
            $tmpPage->URLSegment = self::$url_segment;
            $tmpPage->ID = -1;// Set the page ID to -1 so we dont get the top level pages as its children

            $controller = Page_Controller::create($tmpPage);
            $controller->init();
            
            $this->init();
            
            $Tours = new PaginatedList($this->Tours(), $this->request);
            $Tours->setPageLength(10);
            
            $customisedController = $controller->customise(array(
                "Title" => _t('Tour.SEARCHTITLE', 'Tour.SEARCHTITLE'),
                "Tours" => $Tours,
                "TourSearchForm" => $this->TourSearchForm()
            ));
            
            return $customisedController->renderWith(
                array('Tour_search', 'Tour', 'Page', $this->stat('template_main'), 'BlankPage')
            );
	}
        
        public function TourSearchForm(){
            return TourSearchForm::create($this, "TourSearchForm");
        }
    
        /**
         * Calculate all Tours within the matching time and distance frame
         * 
         * @return boolean
         */
        private function Tours() {
            // Build Query
            $StartBounce = GeoLocation::create_field('GeoLocation', Session::get('TourSearch.Start'), 'Start')->getSQLFilter(Session::get('TourSearch.StartRadius') ? Session::get('TourSearch.StartRadius') : TourSearchForm::$default_radius);
            $GoalBounce = GeoLocation::create_field('GeoLocation', Session::get('TourSearch.Goal'), 'Goal')->getSQLFilter(Session::get('TourSearch.GoalRadius') ? Session::get('TourSearch.GoalRadius') : TourSearchForm::$default_radius);
            
            $StartDate = new DateTime(Session::get('TourSearch.StartDate'));
            // First Interval will remove the diff hours from the StartDate1
            $minDate = $StartDate->sub(new DateInterval('PT'.(Session::get('TourSearch.StartDateDiff')?Session::get('TourSearch.StartDateDiff'):TourSearchForm::$default_diff).'H'))->format('Y-m-d H:i:s');
            // second Interval should add it twice as otherwise the maxDate will be exactly the StartDate
            $maxDate = $StartDate->add(new DateInterval('PT'.(2*(Session::get('TourSearch.StartDateDiff')?Session::get('TourSearch.StartDateDiff'):TourSearchForm::$default_diff).'H')))->format('Y-m-d H:i:s');
            
            $StartDateFilter = "'".$minDate."' < StartDate AND StartDate < '".$maxDate."'";
            
            $filter = $StartDateFilter . ' AND ' . $StartBounce . ' AND ' . $GoalBounce;
            //var_dump($filter); die();
            return Tour::get()->where($filter)->sort('StartDate');
        }
}
