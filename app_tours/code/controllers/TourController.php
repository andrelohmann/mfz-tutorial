<?php
/**
 * Implements a basic Controller
 * @package some config
 * http://doc.silverstripe.org/framework/en/3.1/topics/controller
 */
class TourController extends Controller {
	
	public static $url_topic = 'tour';
	
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
            $Tours = new PaginatedList(self::searchresults(), $this->request);
            $Tours->setPageLength(10);
            
            return $this->customise(new ArrayData(array(
                "Title" => _t('Tour.SEARCHTITLE', 'Tour.SEARCHTITLE'),
                "Tours" => $Tours,
                "TourSearchForm" => $this->TourSearchForm()
            )))->renderWith(
                array('Tour_search', 'Tour', $this->stat('template_main'), $this->stat('template'))
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
        private static function searchresults() {
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
            
            return Tour::get()->where($filter)->sort('StartDate');
        }
}
