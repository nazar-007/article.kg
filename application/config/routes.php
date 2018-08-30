<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'articles';

$route['one_article/(:num)'] = 'articles/one_article/$1';

$route['insert_article_form'] = 'articles/insert_article_form';

$route['search_articles/(:num)'] = 'articles/search_articles/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;