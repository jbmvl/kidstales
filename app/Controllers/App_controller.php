<?php
class App_controller{

	private $viewName;

	function __construct(){

		//default values :
		F3::set('viewTitle', "");
		F3::set('smallHeader', true);
		F3::set('map', false);
		F3::set('viewName', '');
		F3::set('opt', array());		

	}

	//verifying automatically the login before anything else
	function beforeRoute() {
		Intervenant::instance()->checkLogin();
	}

	function home(){
		if(F3::get('connected')) return self::explore(); //redirect to explore if connected
		F3::set('viewTitle', "Kid's Tales");
		F3::set('smallHeader', false);
		F3::set('map', true);
		F3::set('viewName', 'index');
	}

	function explore() {
		F3::set('viewTitle', "Kid's Tales - Explorer");
		F3::set('map', true);
		F3::set('viewName', 'explore');
	}

	function register() {
		F3::set('viewTitle', "Kid's Tales - S'inscrire");
		F3::set('map', true);
		F3::set('viewName', 'register');
	}

	function registerKids() {
		//get signup informations
		if(!self::checkConnexion()) return false;

		F3::set('viewTitle', "Kid's Tales - Inscrire un groupe");
		F3::set('viewName', 'registerKids');
	}

	function dashboard() {
		//get signup informations
		if(!self::checkConnexion()) return false;

		F3::set('viewTitle', "Kid's Tales - Tableau de bord");
		F3::set('viewName', 'dashboard');

		$id=F3::get('PARAMS.id');
	    #récupération de la destination courante	        	     
	     
		/* Données de la table enfants/intervenant */
	     $Child = new Intervenant();   	
	     $datesession = $Child->getDatesByIdIntervenant(F3::get('user')->id_intervenant);
	     F3::set('datesession',Views::instance()->toJSON($datesession,array('date_debut'=>'date_debut',
	     																	'date_fin'=>'date_fin')));   
	     /* Recup id enfant*/
	     $id_e = $Child->getIdEnfants(F3::get('user')->id_intervenant, $datesession[0]['date_debut']);	//id de l'enfant en fonct° de id_inter et date_debut de la session
	     F3::set('id_e',Views::instance()->toJSON($id_e,array('id_enfant'=>'id_enfant')));

	     /* recup nom enfant*/
	     $enfants = $Child->getNomEnfant($id_e[0]['id_enfant']);//Nom de l'enfant en fonction de sont id
	     $std = $enfants[0]['prenom'];
	     F3::set('std',$std);

	    /* Données de la table histoire */    
	    $Hist=new Histoire();
	    $cont = $Hist->getIdHistoire($id_e[0]['id_enfant'], $datesession[0]['date_debut'], $datesession[0]['date_fin']);

	    $date1 = $Hist->getDateHistoire($cont[0]['id_histoire']);
	    $date = $date1[0]['date'];
	    F3::set('date',$date);	     

		/* Données de la table lieu */
	     $Statement = new Lieu();
	     $lieu = $Statement->getNomLieu($cont[0]['id_histoire']);//Nom du lieu en fonction de l'histoire
	     F3::set('lieu',$lieu);	
	}

	function kidsSpace() {
		//get signup informations
		if(!self::checkConnexion()) return false;

		F3::set('viewTitle', "Kid's Tales - Espace enfant");
		F3::set('viewName', 'kidsSpace');
	}

	function checkConnexion() {
		if(!F3::get('connected')) {
			header('HTTP/1.0 403 Forbidden');
			return false;
		}
		return true;
	}

	//adding automatically the view call
	function afterRoute() {

		// This include or not header and footer :
		if(isset($_GET['ajax'])) F3::set('ajaxRequest', true);
		else F3::set('ajaxRequest', false);

		$html = Views::instance()->render(F3::get('viewName').'.php');

		if(F3::get('ajaxRequest')) {
			echo json_encode(array(
				'page_title'=> F3::get('viewTitle'),
				'small_header'=> F3::get('smallHeader'),
				'map'=> F3::get('map'),
				'opt'=> F3::get('opt'),
				'page_content'=> $html));
		}
		else echo $html;
	}


	function __destruct(){

	}
}
?>