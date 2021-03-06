<?php
/**
 * Implements a basic Controller
 * @package some config
 * http://doc.silverstripe.org/framework/en/3.1/topics/controller
 */
class HomeController extends Controller {
	
	public static $url_topic = 'home';
	
	private static $url_segment = 'home';
	
	private static $allowed_actions = array( 
		'index',
                'TourAddSearchForm',
		'terms',
		'privacy',
		'contact',
                'ContactForm',
		'imprint'
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
            
            Requirements::css('app_home/css/home_index.css');
            
            // Vorerst keine Seite erstellt
            return $this->customise(new ArrayList(array(
                "Title" => _t('Home.HOMETITLE', 'Home.HOMETITLE'),
                "Content" => _t('Home.HOMECONTENT', 'Home.HOMECONTENT'),
                "TourAddSearchForm" => $this->TourAddSearchForm()
            )))->renderWith(
                array('Home_index', 'Home', $this->stat('template_main'), $this->stat('template'))
            );
	}
        
        public function TourAddSearchForm(){
            return TourAddSearchForm::create($this, "TourAddSearchForm");
        }

	/**
	 * Show the "login" page
	 *
	 * @return string Returns the "login" page as HTML code.
	 */
	public function terms() {
            
            return $this->customise(new ArrayList(array(
                "Title" => _t('Home.TERMSTITLE', 'Home.TERMSTITLE'),
                "Content" => _t('Home.TERMSCONTENT', 'Home.TERMSCONTENT'),
                "Form" => ''
            )))->renderWith(
                array('Home_terms', 'Home', $this->stat('template_main'), $this->stat('template'))
            );
	}

	/**
	 * Show the "login" page
	 *
	 * @return string Returns the "login" page as HTML code.
	 */
	public function privacy() {
            
            return $this->customise(new ArrayList(array(
                "Title" => _t('Home.PRIVACYTITLE', 'Home.PRIVACYTITLE'),
                "Content" => _t('Home.PRIVACYCONTENT', 'Home.PRIVACYCONTENT'),
                "Form" => ''
            )))->renderWith(
                array('Home_privacy', 'Home', $this->stat('template_main'), $this->stat('template'))
            );
	}

	/**
	 * Show the "login" page
	 *
	 * @return string Returns the "login" page as HTML code.
	 */
	public function contact() {
            
            return $this->customise(new ArrayList(array(
                "Title" => _t('Home.CONTACTTITLE', 'Home.CONTACTTITLE'),
                "Content" => _t('Home.CONTACTCONTENT', 'Home.CONTACTCONTENT'),
                "Form" => $this->ContactForm()
            )))->renderWith(
                array('Home_contact', 'Home', $this->stat('template_main'), $this->stat('template'))
            );
	}
        
        public function ContactForm(){
            // http://doc.silverstripe.org/framework/en/3.1/topics/forms
            return ContactForm::create($this, "ContactForm");
        }

	/**
	 * Show the "login" page
	 *
	 * @return string Returns the "login" page as HTML code.
	 */
	public function imprint() {
            
            return $this->customise(new ArrayList(array(
                "Title" => _t('Home.IMPRINTTITLE', 'Home.IMPRINTTITLE'),
                "Content" => _t('Home.IMPRINTCONTENT', 'Home.IMPRINTCONTENT'),
                "Form" => ''
            )))->renderWith(
                array('Home_imprint', 'Home', $this->stat('template_main'), $this->stat('template'))
            );
	}
}
