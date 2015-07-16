<?php

require_once('workflows.php');
$wf = new Workflows();


$orig = "{query}";

$res = $wf->request( "https://search.cocoapods.org/api/v1/pods.picky.hash.json?ids=20&offset=0&sort=quality&query=".urlencode( $orig ) );
$res = json_decode($res);
$pods = end( current( $res->{"allocations"} ) );
$int = 1;

foreach( $pods as $pod ):
    $wf->result( $int.'.'.time(), $pod->{'link'}, $pod->{'id'}, $pod->{'summary'}, 'icon.png' );
$int++;
endforeach;

$results = $wf->results();
if ( count( $results ) == 0 ):
    $wf->result( 'cocoapodsuggest', $orig, 'No Suggestions', 'No search suggestions found. Search CocoaPods for '.$orig, 'icon.png' );
endif;

echo $wf->toxml();
