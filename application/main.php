<?php

require_once 'core/repository.php';
require_once 'core/router.php';
require_once 'core/request.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/webapp.php';
require_once 'core/model.php';
require_once 'core/routeextructor.php';
require_once 'core/db.php';
require_once 'conf.php';

require_once 'models/css.php';
require_once 'models/js.php';
require_once 'models/redirect.php';

require_once 'lib.php';

ini_set("mbstring.internal_encoding", "UTF-8");

$conf = new TRepository( $configuration );
$register = new TRepository();
$mainModel = new Model();
$mainView = new THView( "main", $mainModel );
$pathExtructor = new TCPUExtructor( $conf->basePath );

$webApp = TWebApp::getWebApp();
$webApp->config = $conf;
$webApp->register = $register;
$webApp->route = $pathExtructor->getRoute();
$webApp->view = $mainView;
$webApp->model = $mainModel;


$cssModel = new ModelCss();
foreach( $conf->css as $css )
    $cssModel->addCssFile( $css );

$jsModel = new ModelJs();
foreach( $conf->js as $js )
    $jsModel->addJsFile( $js );


foreach( $conf->before as $request ){
    $route = new TRouter($request);
    $route->getRequest()->execute();
}

$route = new TRouter($webApp->route);
if ( $route->getRequest()->execute() ){
    foreach( $conf->after as $request ){
        $route = new TRouter($request);
        $route->getRequest()->execute();
    }
}
else
    p404();
$webApp->view->render();





















/*
require_once 'models/news.php';
$mn = new ModelNews( array(new TDb) );
*/
/*
var_dump( $mn->getLatestNews(10) );
*/
/*
$n = new TNews();
$n->topic = "top";
$n->content = "content";
$mn->addNews( $n );
*/

//require_once 'models/support.php';
//$ms = new ModelSupport( array(new TDb) );

/*$tic = new TSupTicket;
$tic->topic = "bla bla bla";
$tic->creator_id = 49;
var_dump($ms->addTicket($tic));*/

/*$smsg = new TSupMsg();
$smsg->creator_id = 3;
$smsg->ticket_id = 1;
$smsg->content = "bla bla blab content";
$ms->addMsg( $smsg );*/

//var_dump( $ms->getAllTickets() );
//var_dump( $ms->getTicketsByUser(1) );
//var_dump( $ms->getMsgs(1) );




//require_once 'models/documents.php';
//$mdoc = new ModelDocuments( array(new TDb) );
//$mdoc->addDocument( "/tmp/img.zip", "bla bla bla document");

//$doc = $mdoc->getDocument( 2 );
//echo $doc->pageCount();

//var_dump( $mdoc->getDocsList() );

//$mdoc->delDocument( 1 );












require_once 'models/mobilephones.php';
$mm = new ModelMobilePhones( array(new TDb) );


/*$mp = new TMobilePhone();
$mp->number = "9211433214";
$mp->description = "Sys admin";
$mp->owner_id = 1;
$mm->addPhone($mp);

$mp = new TMobilePhone();
$mp->number = "9211111111";
$mp->description = "гость";
$mp->owner_id = 2;
$mm->addPhone($mp);*/

/*$mp = new TMobilePhone();
$mp->id=1;
$mp->number = "92111111";
$mp->description = "Sys admin!!!";
$mp->owner_id = 2;
$mm->modPhone($mp);*/

//$mm->delPhone(1);

//var_dump( $mm->getAllPhones() );

//var_dump( $mm->getPhonesByOwner(1) );

//var_dump( $mm->isOwnerPhone(2,7) );

//var_dump( $mm->getPhone(10) );



/*
$mcrg = new TMobileChargeType();
$mcrg->id=16;
$mcrg->description="tttddddkjkjkjkf";
$mcrg->active=1;
$mm->addChargeType($mcrg);*/

//$mm->delChargeType(10);

/*$mcrg = new TMobileChargeType();
$mcrg->id=14;
$mcrg->description="14ddddkjkjkjkfhhh";
$mcrg->active=0;
$mm->modChargeType($mcrg, 13);*/

//var_dump($mm->getAllChargeTypes());
//var_dump($mm->getChargeType(102));
?>