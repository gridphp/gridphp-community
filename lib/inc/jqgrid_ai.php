<?php 
/**
 * Grid 4 PHP Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - https://www.gridphp.com
 * @version 3.1 build 20260820-1928
 * @license: see license.txt included in package
 */

define("AAAES",'.'); define("AAAEP",'"'); define("AAAEM",'~'); define("AAAEJ",'/^-/'); define("AAAEG",'lastListItemIndex'); define("AAAEF"," "); define("AAAED",'lastItem'); define("AAAEB",'>'); define("AAADZ",'|'); define("AAADX",'indent'); define("AAADW",'data'); define("AAADV","''"); define("AAADU","'"); define("AAADR",'off'); define("AAADP",'on'); define("AAADN",'no'); define("AAADM",'yes'); define("AAADK",'false'); define("AAADJ",'true'); define("AAADG",'null'); define("AAADE",': '); define("AAADD",'- '); define("AAADA",' '); define("AAACY",' '); define("AAACX",':'); define("AAACW",'-'); define("AAACV",' '); define("AAACS",''); define("AAACP","ffe97cb337457fee1f146f66ba2553637"); define("AAACO","f57292224bc1db484a36fc6e47f3f71b2"); define("AAACN","We're unable to generate response at this time. Please try again."); define("AAACL","Please enter a valid AI api key, Authentication error."); define("AAACK","10000"); define("AAACI","Please enter a valid AI api endpoint, key and model in the config file."); define("AAACH","suggest_questions:"); define("AAACG","get_insight output:"); define("AAACF","get_insight:"); define("AAACD","```"); define("AAACC","```json"); define("AAACA","Error: No valid JSON found"); define("AAABX","fdb38ad8c760ac1619bf9ef5917bc0ebe:"); define("AAABU","str_getcsv"); define("AAABT","make_json_readable output:"); define("AAABQ","make_json_readable:"); define("AAABP","empty json input"); define("AAABN","choices"); define("AAABM","ff890b9052a455c13fdfabdb87ce1e0ae reponse:"); define("AAABL","Content-Type: application/json"); define("AAABK","json_object"); define("AAABJ","type"); define("AAABH","response_format"); define("AAABE","json"); define("AAABC","stop"); define("AAABB","top_p"); define("AAABA","max_completion_tokens"); define("AAAAY","temperature"); define("AAAAW","content"); define("AAAAV","user"); define("AAAAS","role"); define("AAAAQ","messages"); define("AAAAO","model"); define("AAAAN","Please enter a valid AI API endpoint, API key and model in the config file."); define("AAAAM","message"); define("AAAAK","invalid_api_key"); define("AAAAH","code"); define("AAAAF","error"); define("AAAAC",""); define("AAAAA","EN"); define("ZZZZ","AI_LANG");  ?><?php

if (!defined(ZZZZ))
define(ZZZZ,AAAAA); class ai_grid
{ static $v15d61712450a686a7f365adf4fef581f = AAAAC; static $key = AI_APIKEY; static $v572d4e421e5e6b9bc11d815e8a027112 = AI_ENDPOINT; static $v20f35e630daf44dbfa4c3f68f5399d8c = AI_MODEL; static function ff890b9052a455c13fdfabdb87ce1e0ae($v4ae35dbb42614d2429b7d6d181a950bb, $vea9f91b2cda019730f2891bd12a7a4d6 = array()) { 
if (empty(ai_grid::$key) || empty(ai_grid::$v572d4e421e5e6b9bc11d815e8a027112) || empty(ai_grid::$v20f35e630daf44dbfa4c3f68f5399d8c)) { return json_encode(array(
AAAAF => array(
AAAAH => AAAAK,
AAAAM => AAAAN
)
)); }

$v39802830831bed188884e193d8465226 = ai_grid::$key; $vaa8106611bcfe43fec48e6d1d371de52 = ai_grid::$v572d4e421e5e6b9bc11d815e8a027112; $vdf988dd464bd288c5031b2a4e27ee33d = [
AAAAO => ai_grid::$v20f35e630daf44dbfa4c3f68f5399d8c,
AAAAQ => [[AAAAS => AAAAV, AAAAW => $v4ae35dbb42614d2429b7d6d181a950bb]],
AAAAY => 1,
AAABA => 8192,
AAABB => 1,
AAABC => null
]; if (ai_grid::$v15d61712450a686a7f365adf4fef581f == AAABE)
$vdf988dd464bd288c5031b2a4e27ee33d[AAABH] = [AAABJ=>AAABK]; $vdf988dd464bd288c5031b2a4e27ee33d = array_merge($vdf988dd464bd288c5031b2a4e27ee33d,$vea9f91b2cda019730f2891bd12a7a4d6); $vcf74b4e567c8abaff4bcc94f374cbf8b = json_encode($vdf988dd464bd288c5031b2a4e27ee33d); $vd88fc6edf21ea464d35ff76288b84103 = curl_init(); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_URL, $vaa8106611bcfe43fec48e6d1d371de52); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_RETURNTRANSFER, 1); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_POST, 1); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_HTTPHEADER, [
AAABL,
"Authorization: Bearer $v39802830831bed188884e193d8465226"
]); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_POSTFIELDS, $vcf74b4e567c8abaff4bcc94f374cbf8b); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_SSL_VERIFYHOST, false); $vd1fc8eaf36937be0c3ba8cfe0a2c1bfe = curl_exec($vd88fc6edf21ea464d35ff76288b84103); curl_close($vd88fc6edf21ea464d35ff76288b84103); error_log(AAABM.$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe); $v9a0364b9e99bb480dd25e1f0284c8555 = json_decode($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe, true)[AAABN][0][AAAAM][AAAAW]; return !empty($v9a0364b9e99bb480dd25e1f0284c8555) ? $v9a0364b9e99bb480dd25e1f0284c8555 : $vd1fc8eaf36937be0c3ba8cfe0a2c1bfe; }

static function make_json_readable($v466deec76ecdf5fca6d38571f6324d54, $v5494af1f14a8c19939968c3e9e2d4f79) { 
if (empty(json_decode($v466deec76ecdf5fca6d38571f6324d54,true)))
{ $vb4a88417b3d0170d754c647c30b7216a = new stdClass(); $vb4a88417b3d0170d754c647c30b7216a->error = AAABP; ai_grid::f5c1479a0fb821237d662b94a18ba3233($vb4a88417b3d0170d754c647c30b7216a); return $vb4a88417b3d0170d754c647c30b7216a; }

$v4ae35dbb42614d2429b7d6d181a950bb = "
You are a database architect and business analyst.
You need to convert JSON data to human readable reponse based on the question.

Initial Question was: 
----
$v5494af1f14a8c19939968c3e9e2d4f79
----

Json data from database:
----
$v466deec76ecdf5fca6d38571f6324d54. 
----

Instructions:
If input json data is empty, throw error. 
Skip empty record in json.
Take best answer from the json data.
For single line result, don't use bullets and paragraph.
Try to display long paragraph result in html ul/li tag.
Set numeric values in html strong tag with royal blue color. 
Round of prices in decimals to 2 places.
Dont mention table ID columns in summary.
Give your response in ".AI_LANG." langauge.
Give json output response exactly in this format without any additional text or hallucination: 
{ 'result': { 
'text': '{ai-response}' 
}
}"; ai_grid::$v15d61712450a686a7f365adf4fef581f = AAABE; error_log(AAABQ.$v4ae35dbb42614d2429b7d6d181a950bb); $vb4a88417b3d0170d754c647c30b7216a = ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); error_log(AAABT.($vb4a88417b3d0170d754c647c30b7216a)); $vb4a88417b3d0170d754c647c30b7216a = json_decode($vb4a88417b3d0170d754c647c30b7216a); if ($vb4a88417b3d0170d754c647c30b7216a->error || $vb4a88417b3d0170d754c647c30b7216a->errors) 
ai_grid::f5c1479a0fb821237d662b94a18ba3233($vb4a88417b3d0170d754c647c30b7216a); return $vb4a88417b3d0170d754c647c30b7216a; }

static function summarize_csv_with_groq($v0a14fae61dba08f4b3fb2cbb8c78014f) { 
$vdf347a373b8f92aa0ae3dd920a5ec2f6 = array_map(AAABU, explode("\n", $v0a14fae61dba08f4b3fb2cbb8c78014f)); $v099fb995346f31c749f6e40db0f395e3 = array_shift($vdf347a373b8f92aa0ae3dd920a5ec2f6); $v8d777f385d3dfec8815d20f7496026dc = []; foreach ($vdf347a373b8f92aa0ae3dd920a5ec2f6 as $vf1965a857bc285d26fe22023aa5ab50d) { if (count($vf1965a857bc285d26fe22023aa5ab50d) == count($v099fb995346f31c749f6e40db0f395e3)) { $v8d777f385d3dfec8815d20f7496026dc[] = array_combine($v099fb995346f31c749f6e40db0f395e3, $vf1965a857bc285d26fe22023aa5ab50d); }
}

$vfebb87e8c2e89a709c78a924d81c0f35 = json_encode($v8d777f385d3dfec8815d20f7496026dc, JSON_PRETTY_PRINT); $v4ae35dbb42614d2429b7d6d181a950bb = "Summarize the following CSV file :\n\n$vfebb87e8c2e89a709c78a924d81c0f35"; return ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); }

static function f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb,$vea9f91b2cda019730f2891bd12a7a4d6 = array())
{ return ai_grid::ff890b9052a455c13fdfabdb87ce1e0ae($v4ae35dbb42614d2429b7d6d181a950bb,$vea9f91b2cda019730f2891bd12a7a4d6); }

static function fdb38ad8c760ac1619bf9ef5917bc0ebe($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe) { 
error_log(AAABX.$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe); preg_match('~\{(?:[^{}]|(?R))*\}~', $vd1fc8eaf36937be0c3ba8cfe0a2c1bfe, $v9c28d32df234037773be184dbdafc274); return !empty($v9c28d32df234037773be184dbdafc274[0]) ? $v9c28d32df234037773be184dbdafc274[0] : AAACA; }


static function fe9796203885dd095f805e2f8d9f0454d($v4ae35dbb42614d2429b7d6d181a950bb)
{ $v4ae35dbb42614d2429b7d6d181a950bb = "$v4ae35dbb42614d2429b7d6d181a950bb

Output Instructions
-------------------
- Only response in sample output format with no additional text, hallucination and mutations. 

Sample Output JSON
------------------
{ output: 'response'
}
"; $vb4a88417b3d0170d754c647c30b7216a = ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); $vb4a88417b3d0170d754c647c30b7216a = str_replace(AAACC,AAAAC,$vb4a88417b3d0170d754c647c30b7216a); $vb4a88417b3d0170d754c647c30b7216a = str_replace(AAACD,AAAAC,$vb4a88417b3d0170d754c647c30b7216a); return $vb4a88417b3d0170d754c647c30b7216a; }

static function get_json_filters_by_nlp($vd05b6ed7d2345020440df396d6da7f73,$table,$v5494af1f14a8c19939968c3e9e2d4f79)
{ $v4ae35dbb42614d2429b7d6d181a950bb = "Using following sql table '$table' and fields '$vd05b6ed7d2345020440df396d6da7f73',
Convert the following natural language query into structured JSON as well as SQL query:
Query: '$v5494af1f14a8c19939968c3e9e2d4f79'. 
Return the WHERE clause & ORDER BY clause output in ONLY this JSON format:
{ 'filters': [\n {\"field\": \"field_name\", \"op\": \"op\", \"data\": \"value\"},\n {\"field\": \"field_name\", \"op\": \"op\", \"data\": \"value\"}\n], 'order':{\"field\": \"field_name\", \"sort\": \"sort_order\"}, 'explanation':'short text explaining the filters conditions and prefix with (Filtering ...). Don't tell about sorting.'}.
'op' in json can be one of these: <,<=,>,>=,=,!=,like.
Don't return % in json data for like query.
For single term, always use like operator.
Try to find the single term in all possible table fields.
Don't use database field name and terms in explanation, Use user friendly name.
If no field is found, search all fields with like operator for the term.
"; $vb4a88417b3d0170d754c647c30b7216a = ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); return ai_grid::fdb38ad8c760ac1619bf9ef5917bc0ebe($vb4a88417b3d0170d754c647c30b7216a); }

static function get_insights($vd05b6ed7d2345020440df396d6da7f73,$vac5c74b64b4b8352ef2f181affb5ac2a,$v5494af1f14a8c19939968c3e9e2d4f79)
{ $vd77d5e503ad1439f585ac494268b351b = PHPGRID_DBTYPE; $v4ae35dbb42614d2429b7d6d181a950bb = "
You are a business analyst and a database architect.
Convert the following natural language query into SQL Query compatible with $vd77d5e503ad1439f585ac494268b351b latest version.
Query: '$v5494af1f14a8c19939968c3e9e2d4f79'.

Understanding the database schema from following sql query: 
---
$vac5c74b64b4b8352ef2f181affb5ac2a
---
and fields: '$vd05b6ed7d2345020440df396d6da7f73',

Instructions:
Keep table alias and joins as it source sql. 
Also use fields with table name alias. 
Only use these fields and don't assume any new field. 
If there are entity id and name both present in fields, try to show result with name.
For multiple records in result, limit sql query to best 10 records and prefer giving aggregate result.
Round off numeric values to zero places and don't mention in explanation.
Return json only in following format with no extra text or hallucination: 
------
{ 'results':
[
{'sql':'{SQL-QUERY}','explanation':'{SQL-QUERY-EXPLANATION}'},
{'sql':'{SQL-QUERY}','explanation':'{SQL-QUERY-EXPLANATION}'}
]
} 
"; error_log(AAACF.$v4ae35dbb42614d2429b7d6d181a950bb); ai_grid::$v15d61712450a686a7f365adf4fef581f = AAABE; $vb4a88417b3d0170d754c647c30b7216a = ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); error_log(AAACG.$vb4a88417b3d0170d754c647c30b7216a); $vb4a88417b3d0170d754c647c30b7216a = json_decode($vb4a88417b3d0170d754c647c30b7216a); if ($vb4a88417b3d0170d754c647c30b7216a->error || $vb4a88417b3d0170d754c647c30b7216a->errors) 
ai_grid::f5c1479a0fb821237d662b94a18ba3233($vb4a88417b3d0170d754c647c30b7216a); return $vb4a88417b3d0170d754c647c30b7216a; }

static function suggest_questions($vd05b6ed7d2345020440df396d6da7f73,$vac5c74b64b4b8352ef2f181affb5ac2a)
{ $v4ae35dbb42614d2429b7d6d181a950bb = "
You are a business analyst and a database architect.
By understanding following sql query: 
---
$vac5c74b64b4b8352ef2f181affb5ac2a
---
and fields: '$vd05b6ed7d2345020440df396d6da7f73',
Suggest the questions that can be asked to summarize the data.
Don't suggest question which needs an input.
Don't suggest question where expected response is large text.
Limit to 5 questions.
Give your questions in ".AI_LANG." langauge.
Return json only in following format with no extra text and assumption: 
{ 'results':
[
{'question':'{ai-question-content}'},
{'question':'{ai-question-content}'}
]
}"; error_log(AAACH.$v4ae35dbb42614d2429b7d6d181a950bb); ai_grid::$v15d61712450a686a7f365adf4fef581f = AAABE; $vb4a88417b3d0170d754c647c30b7216a = ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); $vb4a88417b3d0170d754c647c30b7216a = json_decode($vb4a88417b3d0170d754c647c30b7216a); if ($vb4a88417b3d0170d754c647c30b7216a->error || $vb4a88417b3d0170d754c647c30b7216a->errors) 
ai_grid::f5c1479a0fb821237d662b94a18ba3233($vb4a88417b3d0170d754c647c30b7216a); return $vb4a88417b3d0170d754c647c30b7216a; }

static function f5c1479a0fb821237d662b94a18ba3233(&$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe)
{ if (empty($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error))
$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error = $vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->errors[0]; if ($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error)
{ if ($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error->code == AAAAK)
$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error = AAACI; else if ($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error->code == AAACK)
$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error = AAACL; else
$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error = AAACN; }
}
}

if (!defined(AAACO) && !defined(AAACP))
{ 
function ffe97cb337457fee1f146f66ba2553637($vf1f713c9e000f5d3f280adbd124df4f5, $v03fdad155b7548884584c7c39b0c5cd2 = 2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 = 0, $v4e5868d676cb634aa75b125a0f741abf = 0) { $v6eedc03a68a69933c763e674f2d7c42f = AAACS; $v851f5ac9941d720844d143ed9cfcf60a = str_repeat(AAACV, $vead60a4fe9e35d6e4f9f3e8ebdf32d02); foreach ($vf1f713c9e000f5d3f280adbd124df4f5 as $key => $v2063c1608d6e0baf80249c42e2be5804) { $v867fd4c34db986c640ac965d6b58310c = is_int($key); if (is_array($v2063c1608d6e0baf80249c42e2be5804) && !empty($v2063c1608d6e0baf80249c42e2be5804)) { $v468ba46bbdda22d8ea7081d8068ed7df = array_keys($v2063c1608d6e0baf80249c42e2be5804) === range(0, count($v2063c1608d6e0baf80249c42e2be5804) - 1); if ($v867fd4c34db986c640ac965d6b58310c) { if ($v468ba46bbdda22d8ea7081d8068ed7df) { foreach ($v2063c1608d6e0baf80249c42e2be5804 as $v447b7147e84be512208dcc0995d67ebc) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAACW; if (is_array($v447b7147e84be512208dcc0995d67ebc)) { $v8b04d5e3775d298e78455efc5ca404d5 = true; foreach ($v447b7147e84be512208dcc0995d67ebc as $v518d8dec3947df909fe6e4c9940f98a6 => $v99ec682294cfb0f1c96b29ac20433cf6) { if ($v8b04d5e3775d298e78455efc5ca404d5) { $v6eedc03a68a69933c763e674f2d7c42f .= AAACV . $v518d8dec3947df909fe6e4c9940f98a6 . AAACX; $v8b04d5e3775d298e78455efc5ca404d5 = false; } else { $v6eedc03a68a69933c763e674f2d7c42f .= "\n" . $v851f5ac9941d720844d143ed9cfcf60a . AAACY . $v518d8dec3947df909fe6e4c9940f98a6 . AAACX; }

if (is_array($v99ec682294cfb0f1c96b29ac20433cf6)) { $v6eedc03a68a69933c763e674f2d7c42f .= "\n" . ffe97cb337457fee1f146f66ba2553637($v99ec682294cfb0f1c96b29ac20433cf6, $v03fdad155b7548884584c7c39b0c5cd2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 + 4, $v4e5868d676cb634aa75b125a0f741abf); } elseif (is_string($v99ec682294cfb0f1c96b29ac20433cf6) && strpos($v99ec682294cfb0f1c96b29ac20433cf6, "\n") !== false) { $v6eedc03a68a69933c763e674f2d7c42f .= " |\n"; $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v99ec682294cfb0f1c96b29ac20433cf6); foreach ($v980da98409d058c365664ff7ea33dd6b as $v6438c669e0d0de98e6929c2cc0fac474) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADA . $v6438c669e0d0de98e6929c2cc0fac474 . "\n"; }
} else { $v6eedc03a68a69933c763e674f2d7c42f .= AAACV . f8e5b15c74a3fe89571128eb66f54897d($v99ec682294cfb0f1c96b29ac20433cf6) . "\n"; }
}
} else { $v6eedc03a68a69933c763e674f2d7c42f .= AAACV . f8e5b15c74a3fe89571128eb66f54897d($v447b7147e84be512208dcc0995d67ebc) . "\n"; }
}
} else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAACW; $v8b04d5e3775d298e78455efc5ca404d5 = true; foreach ($v2063c1608d6e0baf80249c42e2be5804 as $v518d8dec3947df909fe6e4c9940f98a6 => $v99ec682294cfb0f1c96b29ac20433cf6) { if ($v8b04d5e3775d298e78455efc5ca404d5) { $v6eedc03a68a69933c763e674f2d7c42f .= AAACV . $v518d8dec3947df909fe6e4c9940f98a6 . AAACX; $v8b04d5e3775d298e78455efc5ca404d5 = false; } else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAACY . $v518d8dec3947df909fe6e4c9940f98a6 . AAACX; }

if (is_array($v99ec682294cfb0f1c96b29ac20433cf6)) { $v6eedc03a68a69933c763e674f2d7c42f .= "\n" . ffe97cb337457fee1f146f66ba2553637($v99ec682294cfb0f1c96b29ac20433cf6, $v03fdad155b7548884584c7c39b0c5cd2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 + 4, $v4e5868d676cb634aa75b125a0f741abf); } elseif (is_string($v99ec682294cfb0f1c96b29ac20433cf6) && strpos($v99ec682294cfb0f1c96b29ac20433cf6, "\n") !== false) { $v6eedc03a68a69933c763e674f2d7c42f .= " |\n"; $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v99ec682294cfb0f1c96b29ac20433cf6); foreach ($v980da98409d058c365664ff7ea33dd6b as $v6438c669e0d0de98e6929c2cc0fac474) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADA . $v6438c669e0d0de98e6929c2cc0fac474 . "\n"; }
} else { $v6eedc03a68a69933c763e674f2d7c42f .= AAACV . f8e5b15c74a3fe89571128eb66f54897d($v99ec682294cfb0f1c96b29ac20433cf6) . "\n"; }
}
}
} else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . $key . AAACX; if ($v468ba46bbdda22d8ea7081d8068ed7df && $vead60a4fe9e35d6e4f9f3e8ebdf32d02 < $v03fdad155b7548884584c7c39b0c5cd2 * 2) { $v6eedc03a68a69933c763e674f2d7c42f .= "\n"; $v6eedc03a68a69933c763e674f2d7c42f .= ffe97cb337457fee1f146f66ba2553637($v2063c1608d6e0baf80249c42e2be5804, $v03fdad155b7548884584c7c39b0c5cd2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 + 2, $v4e5868d676cb634aa75b125a0f741abf); } else { $v6eedc03a68a69933c763e674f2d7c42f .= "\n"; $v6eedc03a68a69933c763e674f2d7c42f .= ffe97cb337457fee1f146f66ba2553637($v2063c1608d6e0baf80249c42e2be5804, $v03fdad155b7548884584c7c39b0c5cd2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 + 2, $v4e5868d676cb634aa75b125a0f741abf); }
}
} else { if ($v867fd4c34db986c640ac965d6b58310c) { if (is_string($v2063c1608d6e0baf80249c42e2be5804) && strpos($v2063c1608d6e0baf80249c42e2be5804, "\n") !== false) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . '- |\n'; $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v2063c1608d6e0baf80249c42e2be5804); foreach ($v980da98409d058c365664ff7ea33dd6b as $v6438c669e0d0de98e6929c2cc0fac474) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAACY . $v6438c669e0d0de98e6929c2cc0fac474 . "\n"; }
} else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADD . f8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804) . "\n"; }
} else { if (is_string($v2063c1608d6e0baf80249c42e2be5804) && strpos($v2063c1608d6e0baf80249c42e2be5804, "\n") !== false) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . $key . ': |\n'; $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v2063c1608d6e0baf80249c42e2be5804); foreach ($v980da98409d058c365664ff7ea33dd6b as $v6438c669e0d0de98e6929c2cc0fac474) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAACY . $v6438c669e0d0de98e6929c2cc0fac474 . "\n"; }
} else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . $key . AAADE . f8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804) . "\n"; }
}
}
}

return $v6eedc03a68a69933c763e674f2d7c42f; } 


function f8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804) { if (is_null($v2063c1608d6e0baf80249c42e2be5804)) { return AAADG; }

if (is_bool($v2063c1608d6e0baf80249c42e2be5804)) { return $v2063c1608d6e0baf80249c42e2be5804 ? AAADJ : AAADK; }

if (is_numeric($v2063c1608d6e0baf80249c42e2be5804)) { return (string)$v2063c1608d6e0baf80249c42e2be5804; }

$v2063c1608d6e0baf80249c42e2be5804 = (string)$v2063c1608d6e0baf80249c42e2be5804; if (preg_match('/[:\[\]{}#&*!|>\'"%@`]/', $v2063c1608d6e0baf80249c42e2be5804) || 
preg_match('/^\s|\s$/', $v2063c1608d6e0baf80249c42e2be5804) ||
in_array(strtolower($v2063c1608d6e0baf80249c42e2be5804), [AAADJ, AAADK, AAADG, AAADM, AAADN, AAADP, AAADR])) { return AAADU . str_replace(AAADU, AAADV, $v2063c1608d6e0baf80249c42e2be5804) . AAADU; }

return $v2063c1608d6e0baf80249c42e2be5804; }



function f57292224bc1db484a36fc6e47f3f71b2($v6eedc03a68a69933c763e674f2d7c42f) { $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v6eedc03a68a69933c763e674f2d7c42f); $vb4a88417b3d0170d754c647c30b7216a = []; $vfac2a47adace059aff113283a03f6760 = [[AAADW => &$vb4a88417b3d0170d754c647c30b7216a, AAADX => -1]]; $veac22b102a30112d6e74c8dc6af0b915 = -1; $vab0e549d2a8443cc837f6184800edbd4 = null; $vec0650218823d76a3a7b1e31fee1893c = null; $va086100d0950b15b426b1030d740c1fc = null; $v1ef0fe4040450a5ce2ffc5521d618374 = []; $v77cd907dd11c2e6abe84546dd30f33eb = null; 
foreach ($v980da98409d058c365664ff7ea33dd6b as $vc4b559ef1fbd45d771bf4a30dcccd2b7 => $v6438c669e0d0de98e6929c2cc0fac474) { preg_match('/^(\s*)/', $v6438c669e0d0de98e6929c2cc0fac474, $v9c28d32df234037773be184dbdafc274); $vead60a4fe9e35d6e4f9f3e8ebdf32d02 = strlen($v9c28d32df234037773be184dbdafc274[1]); $vc5a4c370532d8090ef6f7e9e0127e9a0 = trim($v6438c669e0d0de98e6929c2cc0fac474); if ($vab0e549d2a8443cc837f6184800edbd4 !== null) { if ($vc5a4c370532d8090ef6f7e9e0127e9a0 === AAACS || $vead60a4fe9e35d6e4f9f3e8ebdf32d02 > $va086100d0950b15b426b1030d740c1fc) { if ($vab0e549d2a8443cc837f6184800edbd4 === AAADZ) { if ($v77cd907dd11c2e6abe84546dd30f33eb === null && $vc5a4c370532d8090ef6f7e9e0127e9a0 !== AAACS) { $v77cd907dd11c2e6abe84546dd30f33eb = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; }

if ($v77cd907dd11c2e6abe84546dd30f33eb !== null && $vead60a4fe9e35d6e4f9f3e8ebdf32d02 >= $v77cd907dd11c2e6abe84546dd30f33eb) { $v1ef0fe4040450a5ce2ffc5521d618374[] = substr($v6438c669e0d0de98e6929c2cc0fac474, $v77cd907dd11c2e6abe84546dd30f33eb); } else { $v1ef0fe4040450a5ce2ffc5521d618374[] = $vc5a4c370532d8090ef6f7e9e0127e9a0; }
} elseif ($vab0e549d2a8443cc837f6184800edbd4 === AAAEB) { $v1ef0fe4040450a5ce2ffc5521d618374[] = $vc5a4c370532d8090ef6f7e9e0127e9a0; }
continue; } else { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAADW]; if (isset($vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED])) { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED]; }

if ($vab0e549d2a8443cc837f6184800edbd4 === AAADZ) { $v43b5c9175984c071f30b873fdce0a000[$vec0650218823d76a3a7b1e31fee1893c] = implode("\n", $v1ef0fe4040450a5ce2ffc5521d618374); } else { $v43b5c9175984c071f30b873fdce0a000[$vec0650218823d76a3a7b1e31fee1893c] = implode(AAAEF, $v1ef0fe4040450a5ce2ffc5521d618374); }

$vab0e549d2a8443cc837f6184800edbd4 = null; $vec0650218823d76a3a7b1e31fee1893c = null; $va086100d0950b15b426b1030d740c1fc = null; $v1ef0fe4040450a5ce2ffc5521d618374 = []; $v77cd907dd11c2e6abe84546dd30f33eb = null; }
}

if (trim($v6438c669e0d0de98e6929c2cc0fac474) === AAACS || preg_match('/^\s*#/', $v6438c669e0d0de98e6929c2cc0fac474)) { continue; }

while (count($vfac2a47adace059aff113283a03f6760) > 1 && $vead60a4fe9e35d6e4f9f3e8ebdf32d02 <= $vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAADX]) { array_pop($vfac2a47adace059aff113283a03f6760); }

$v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAADW]; if (preg_match('/^-\s+(.*)$/', $vc5a4c370532d8090ef6f7e9e0127e9a0, $v9c28d32df234037773be184dbdafc274)) { $v9a0364b9e99bb480dd25e1f0284c8555 = $v9c28d32df234037773be184dbdafc274[1]; if (!is_array($v43b5c9175984c071f30b873fdce0a000)) { $v43b5c9175984c071f30b873fdce0a000 = []; }

if (preg_match('/^([a-zA-Z_][a-zA-Z0-9_\s]*?)\s*:\s*(.*)$/', $v9a0364b9e99bb480dd25e1f0284c8555, $ve3a9d482cc1a6e56371b72f814564e5c)) { $key = trim($ve3a9d482cc1a6e56371b72f814564e5c[1]); $v2063c1608d6e0baf80249c42e2be5804 = trim($ve3a9d482cc1a6e56371b72f814564e5c[2]); $v67f83105b67da710b89f767d0c89af66 = []; if ($v2063c1608d6e0baf80249c42e2be5804 === AAADZ || $v2063c1608d6e0baf80249c42e2be5804 === AAAEB) { $vab0e549d2a8443cc837f6184800edbd4 = $v2063c1608d6e0baf80249c42e2be5804; $vec0650218823d76a3a7b1e31fee1893c = $key; $va086100d0950b15b426b1030d740c1fc = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; $v1ef0fe4040450a5ce2ffc5521d618374 = []; $v77cd907dd11c2e6abe84546dd30f33eb = null; $v67f83105b67da710b89f767d0c89af66[$key] = AAACS; } elseif ($v2063c1608d6e0baf80249c42e2be5804 !== AAACS) { $v67f83105b67da710b89f767d0c89af66[$key] = unf8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804); } else { $v67f83105b67da710b89f767d0c89af66[$key] = []; $vfac2a47adace059aff113283a03f6760[] = [AAADW => &$v67f83105b67da710b89f767d0c89af66[$key], AAADX => $vead60a4fe9e35d6e4f9f3e8ebdf32d02]; }

$v43b5c9175984c071f30b873fdce0a000[] = $v67f83105b67da710b89f767d0c89af66; $vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED] = &$v43b5c9175984c071f30b873fdce0a000[count($v43b5c9175984c071f30b873fdce0a000) - 1]; } else { $v43b5c9175984c071f30b873fdce0a000[] = unf8e5b15c74a3fe89571128eb66f54897d($v9a0364b9e99bb480dd25e1f0284c8555); $vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEG] = count($v43b5c9175984c071f30b873fdce0a000) - 1; }

$veac22b102a30112d6e74c8dc6af0b915 = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; continue; }

if ($vead60a4fe9e35d6e4f9f3e8ebdf32d02 > $veac22b102a30112d6e74c8dc6af0b915 && !preg_match(AAAEJ, $vc5a4c370532d8090ef6f7e9e0127e9a0) && !preg_match('/^([a-zA-Z_][a-zA-Z0-9_\s]*?)\s*:/', $vc5a4c370532d8090ef6f7e9e0127e9a0)) { if (isset($vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEG])) { $v6f2ee54dde3dc60f4a41e7dfb940851a = $vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEG]; $v43b5c9175984c071f30b873fdce0a000[$v6f2ee54dde3dc60f4a41e7dfb940851a] .= AAACV . $vc5a4c370532d8090ef6f7e9e0127e9a0; continue; }
}

if (preg_match('/^([^:]+):\s*(.*)$/', $vc5a4c370532d8090ef6f7e9e0127e9a0, $v9c28d32df234037773be184dbdafc274)) { $key = trim($v9c28d32df234037773be184dbdafc274[1]); $v2063c1608d6e0baf80249c42e2be5804 = trim($v9c28d32df234037773be184dbdafc274[2]); if (isset($vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED])) { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED]; }

if (!is_array($v43b5c9175984c071f30b873fdce0a000)) { $v43b5c9175984c071f30b873fdce0a000 = []; }

if ($v2063c1608d6e0baf80249c42e2be5804 === AAADZ || $v2063c1608d6e0baf80249c42e2be5804 === AAAEB) { $vab0e549d2a8443cc837f6184800edbd4 = $v2063c1608d6e0baf80249c42e2be5804; $vec0650218823d76a3a7b1e31fee1893c = $key; $va086100d0950b15b426b1030d740c1fc = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; $v1ef0fe4040450a5ce2ffc5521d618374 = []; $v77cd907dd11c2e6abe84546dd30f33eb = null; $v43b5c9175984c071f30b873fdce0a000[$key] = AAACS; } elseif ($v2063c1608d6e0baf80249c42e2be5804 !== AAACS) { $v43b5c9175984c071f30b873fdce0a000[$key] = unf8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804); } else { if (!isset($v43b5c9175984c071f30b873fdce0a000[$key])) { $v43b5c9175984c071f30b873fdce0a000[$key] = []; }
$vfac2a47adace059aff113283a03f6760[] = [AAADW => &$v43b5c9175984c071f30b873fdce0a000[$key], AAADX => $vead60a4fe9e35d6e4f9f3e8ebdf32d02]; }

$veac22b102a30112d6e74c8dc6af0b915 = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; }
}

if ($vab0e549d2a8443cc837f6184800edbd4 !== null) { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAADW]; if (isset($vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED])) { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED]; }

if ($vab0e549d2a8443cc837f6184800edbd4 === AAADZ) { $v43b5c9175984c071f30b873fdce0a000[$vec0650218823d76a3a7b1e31fee1893c] = implode("\n", $v1ef0fe4040450a5ce2ffc5521d618374); } else { $v43b5c9175984c071f30b873fdce0a000[$vec0650218823d76a3a7b1e31fee1893c] = implode(AAAEF, $v1ef0fe4040450a5ce2ffc5521d618374); }
}

return $vb4a88417b3d0170d754c647c30b7216a; }


function unf8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804) { $v2063c1608d6e0baf80249c42e2be5804 = trim($v2063c1608d6e0baf80249c42e2be5804); if ($v2063c1608d6e0baf80249c42e2be5804 === AAADG || $v2063c1608d6e0baf80249c42e2be5804 === AAAEM || $v2063c1608d6e0baf80249c42e2be5804 === AAACS) { return null; }

if (in_array(strtolower($v2063c1608d6e0baf80249c42e2be5804), [AAADJ, AAADM, AAADP])) { return true; }
if (in_array(strtolower($v2063c1608d6e0baf80249c42e2be5804), [AAADK, AAADN, AAADR])) { return false; }

if ((substr($v2063c1608d6e0baf80249c42e2be5804, 0, 1) === AAAEP && substr($v2063c1608d6e0baf80249c42e2be5804, -1) === AAAEP) ||
(substr($v2063c1608d6e0baf80249c42e2be5804, 0, 1) === AAADU && substr($v2063c1608d6e0baf80249c42e2be5804, -1) === AAADU)) { $v2063c1608d6e0baf80249c42e2be5804 = substr($v2063c1608d6e0baf80249c42e2be5804, 1, -1); if (strpos($v2063c1608d6e0baf80249c42e2be5804, AAADV) !== false) { $v2063c1608d6e0baf80249c42e2be5804 = str_replace(AAADV, AAADU, $v2063c1608d6e0baf80249c42e2be5804); }
return $v2063c1608d6e0baf80249c42e2be5804; }

if (is_numeric($v2063c1608d6e0baf80249c42e2be5804)) { return strpos($v2063c1608d6e0baf80249c42e2be5804, AAAES) !== false ? (float)$v2063c1608d6e0baf80249c42e2be5804 : (int)$v2063c1608d6e0baf80249c42e2be5804; }

return $v2063c1608d6e0baf80249c42e2be5804; }

}?>