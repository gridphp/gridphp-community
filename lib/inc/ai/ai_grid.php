<?php 
/**
 * Grid 4 PHP Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - https://www.gridphp.com
 * @version 3.1 build 20260713-0531
 * @license: see license.txt included in package
 */

define("AAAEU",'.'); define("AAAER",'"'); define("AAAEP",'~'); define("AAAEN",'/^-/'); define("AAAEM",'lastListItemIndex'); define("AAAEK"," "); define("AAAEJ",'lastItem'); define("AAAEI",'>'); define("AAAEG",'|'); define("AAAEE",'indent'); define("AAAED",'data'); define("AAAEA","''"); define("AAADZ","'"); define("AAADY",'off'); define("AAADW",'on'); define("AAADU",'no'); define("AAADS",'yes'); define("AAADR",'false'); define("AAADP",'true'); define("AAADO",'null'); define("AAADM",': '); define("AAADL",'- '); define("AAADJ",' '); define("AAADG",' '); define("AAADE",':'); define("AAADB",'-'); define("AAADA",' '); define("AAACY",''); define("AAACW","ffe97cb337457fee1f146f66ba2553637"); define("AAACT","f57292224bc1db484a36fc6e47f3f71b2"); define("AAACS","We're unable to generate response at this time. Please try again."); define("AAACR","Please enter a valid api key in configuration file."); define("AAACQ","invalid_api_key"); define("AAACN","suggest_questions:"); define("AAACM","get_insight output:"); define("AAACK","get_insight:"); define("AAACH","```"); define("AAACF","```json"); define("AAACD","Error: No valid JSON found"); define("AAACA","fdb38ad8c760ac1619bf9ef5917bc0ebe:"); define("AAABZ","str_getcsv"); define("AAABW","make_json_readable output:"); define("AAABT","make_json_readable:"); define("AAABR","empty json input"); define("AAABO","message"); define("AAABM","choices"); define("AAABK","ff890b9052a455c13fdfabdb87ce1e0ae reponse:"); define("AAABI","Content-Type: application/json"); define("AAABF","json_object"); define("AAABD","type"); define("AAABB","response_format"); define("AAABA","json"); define("AAAAX","stop"); define("AAAAV","top_p"); define("AAAAT","max_completion_tokens"); define("AAAAS","temperature"); define("AAAAR","content"); define("AAAAQ","user"); define("AAAAP","role"); define("AAAAN","messages"); define("AAAAK","meta-llama/llama-4-scout-17b-16e-instruct"); define("AAAAH","model"); define("AAAAE","https://api.groq.com/openai/v1/chat/completions"); define("AAAAC",""); define("AAAAA","EN"); define("ZZZZ","AI_LANG");  ?><?php

if (!defined(ZZZZ))
define(ZZZZ,AAAAA); class ai_grid
{ static $v15d61712450a686a7f365adf4fef581f = AAAAC; static $key = AAAAC; static function ff890b9052a455c13fdfabdb87ce1e0ae($v4ae35dbb42614d2429b7d6d181a950bb, $vea9f91b2cda019730f2891bd12a7a4d6 = array()) { 
$vaa8106611bcfe43fec48e6d1d371de52 = AAAAE; $v39802830831bed188884e193d8465226 = ai_grid::$key; $vdf988dd464bd288c5031b2a4e27ee33d = [
AAAAH => AAAAK,
AAAAN => [[AAAAP => AAAAQ, AAAAR => $v4ae35dbb42614d2429b7d6d181a950bb]],
AAAAS => 1,
AAAAT => 8192,
AAAAV => 1,
AAAAX => null
]; if (ai_grid::$v15d61712450a686a7f365adf4fef581f == AAABA)
$vdf988dd464bd288c5031b2a4e27ee33d[AAABB] = [AAABD=>AAABF]; $vdf988dd464bd288c5031b2a4e27ee33d = array_merge($vdf988dd464bd288c5031b2a4e27ee33d,$vea9f91b2cda019730f2891bd12a7a4d6); $vcf74b4e567c8abaff4bcc94f374cbf8b = json_encode($vdf988dd464bd288c5031b2a4e27ee33d); $vd88fc6edf21ea464d35ff76288b84103 = curl_init(); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_URL, $vaa8106611bcfe43fec48e6d1d371de52); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_RETURNTRANSFER, 1); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_POST, 1); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_HTTPHEADER, [
AAABI,
"Authorization: Bearer $v39802830831bed188884e193d8465226"
]); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_POSTFIELDS, $vcf74b4e567c8abaff4bcc94f374cbf8b); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($vd88fc6edf21ea464d35ff76288b84103, CURLOPT_SSL_VERIFYHOST, false); $vd1fc8eaf36937be0c3ba8cfe0a2c1bfe = curl_exec($vd88fc6edf21ea464d35ff76288b84103); curl_close($vd88fc6edf21ea464d35ff76288b84103); error_log(AAABK.$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe); $v9a0364b9e99bb480dd25e1f0284c8555 = json_decode($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe, true)[AAABM][0][AAABO][AAAAR]; return !empty($v9a0364b9e99bb480dd25e1f0284c8555) ? $v9a0364b9e99bb480dd25e1f0284c8555 : $vd1fc8eaf36937be0c3ba8cfe0a2c1bfe; }

static function make_json_readable($v466deec76ecdf5fca6d38571f6324d54, $v5494af1f14a8c19939968c3e9e2d4f79) { 
if (empty(json_decode($v466deec76ecdf5fca6d38571f6324d54,true)))
{ $vb4a88417b3d0170d754c647c30b7216a = new stdClass(); $vb4a88417b3d0170d754c647c30b7216a->error = AAABR; ai_grid::f5c1479a0fb821237d662b94a18ba3233($vb4a88417b3d0170d754c647c30b7216a); return $vb4a88417b3d0170d754c647c30b7216a; }

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
}"; ai_grid::$v15d61712450a686a7f365adf4fef581f = AAABA; error_log(AAABT.$v4ae35dbb42614d2429b7d6d181a950bb); $vb4a88417b3d0170d754c647c30b7216a = ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); error_log(AAABW.($vb4a88417b3d0170d754c647c30b7216a)); $vb4a88417b3d0170d754c647c30b7216a = json_decode($vb4a88417b3d0170d754c647c30b7216a); if ($vb4a88417b3d0170d754c647c30b7216a->error) 
ai_grid::f5c1479a0fb821237d662b94a18ba3233($vb4a88417b3d0170d754c647c30b7216a); return $vb4a88417b3d0170d754c647c30b7216a; }

static function summarize_csv_with_groq($v0a14fae61dba08f4b3fb2cbb8c78014f) { 
$vdf347a373b8f92aa0ae3dd920a5ec2f6 = array_map(AAABZ, explode("\n", $v0a14fae61dba08f4b3fb2cbb8c78014f)); $v099fb995346f31c749f6e40db0f395e3 = array_shift($vdf347a373b8f92aa0ae3dd920a5ec2f6); $v8d777f385d3dfec8815d20f7496026dc = []; foreach ($vdf347a373b8f92aa0ae3dd920a5ec2f6 as $vf1965a857bc285d26fe22023aa5ab50d) { if (count($vf1965a857bc285d26fe22023aa5ab50d) == count($v099fb995346f31c749f6e40db0f395e3)) { $v8d777f385d3dfec8815d20f7496026dc[] = array_combine($v099fb995346f31c749f6e40db0f395e3, $vf1965a857bc285d26fe22023aa5ab50d); }
}

$vfebb87e8c2e89a709c78a924d81c0f35 = json_encode($v8d777f385d3dfec8815d20f7496026dc, JSON_PRETTY_PRINT); $v4ae35dbb42614d2429b7d6d181a950bb = "Summarize the following CSV file :\n\n$vfebb87e8c2e89a709c78a924d81c0f35"; return ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); }

static function f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb,$vea9f91b2cda019730f2891bd12a7a4d6 = array())
{ return ai_grid::ff890b9052a455c13fdfabdb87ce1e0ae($v4ae35dbb42614d2429b7d6d181a950bb,$vea9f91b2cda019730f2891bd12a7a4d6); }

static function fdb38ad8c760ac1619bf9ef5917bc0ebe($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe) { 
error_log(AAACA.$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe); preg_match('~\{(?:[^{}]|(?R))*\}~', $vd1fc8eaf36937be0c3ba8cfe0a2c1bfe, $v9c28d32df234037773be184dbdafc274); return !empty($v9c28d32df234037773be184dbdafc274[0]) ? $v9c28d32df234037773be184dbdafc274[0] : AAACD; }


static function fe9796203885dd095f805e2f8d9f0454d($v4ae35dbb42614d2429b7d6d181a950bb)
{ $v4ae35dbb42614d2429b7d6d181a950bb = "$v4ae35dbb42614d2429b7d6d181a950bb

Output Instructions
-------------------
- Only response in sample output format with no additional text, hallucination and mutations. 

Sample Output JSON
------------------
{ output: 'response'
}
"; $vb4a88417b3d0170d754c647c30b7216a = ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); $vb4a88417b3d0170d754c647c30b7216a = str_replace(AAACF,AAAAC,$vb4a88417b3d0170d754c647c30b7216a); $vb4a88417b3d0170d754c647c30b7216a = str_replace(AAACH,AAAAC,$vb4a88417b3d0170d754c647c30b7216a); return $vb4a88417b3d0170d754c647c30b7216a; }

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
"; error_log(AAACK.$v4ae35dbb42614d2429b7d6d181a950bb); ai_grid::$v15d61712450a686a7f365adf4fef581f = AAABA; $vb4a88417b3d0170d754c647c30b7216a = ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); error_log(AAACM.$vb4a88417b3d0170d754c647c30b7216a); $vb4a88417b3d0170d754c647c30b7216a = json_decode($vb4a88417b3d0170d754c647c30b7216a); if ($vb4a88417b3d0170d754c647c30b7216a->error) 
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
}"; error_log(AAACN.$v4ae35dbb42614d2429b7d6d181a950bb); ai_grid::$v15d61712450a686a7f365adf4fef581f = AAABA; $vb4a88417b3d0170d754c647c30b7216a = ai_grid::f5ed33f7008771c9d49e3716aeaeca581($v4ae35dbb42614d2429b7d6d181a950bb); $vb4a88417b3d0170d754c647c30b7216a = json_decode($vb4a88417b3d0170d754c647c30b7216a); if ($vb4a88417b3d0170d754c647c30b7216a->error) 
ai_grid::f5c1479a0fb821237d662b94a18ba3233($vb4a88417b3d0170d754c647c30b7216a); return $vb4a88417b3d0170d754c647c30b7216a; }

static function f5c1479a0fb821237d662b94a18ba3233(&$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe)
{ if ($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error)
{ if ($vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error->code == AAACQ)
$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error = AAACR; else
$vd1fc8eaf36937be0c3ba8cfe0a2c1bfe->error = AAACS; }
}
}

if (!defined(AAACT) && !defined(AAACW))
{ 
function ffe97cb337457fee1f146f66ba2553637($vf1f713c9e000f5d3f280adbd124df4f5, $v03fdad155b7548884584c7c39b0c5cd2 = 2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 = 0, $v4e5868d676cb634aa75b125a0f741abf = 0) { $v6eedc03a68a69933c763e674f2d7c42f = AAACY; $v851f5ac9941d720844d143ed9cfcf60a = str_repeat(AAADA, $vead60a4fe9e35d6e4f9f3e8ebdf32d02); foreach ($vf1f713c9e000f5d3f280adbd124df4f5 as $key => $v2063c1608d6e0baf80249c42e2be5804) { $v867fd4c34db986c640ac965d6b58310c = is_int($key); if (is_array($v2063c1608d6e0baf80249c42e2be5804) && !empty($v2063c1608d6e0baf80249c42e2be5804)) { $v468ba46bbdda22d8ea7081d8068ed7df = array_keys($v2063c1608d6e0baf80249c42e2be5804) === range(0, count($v2063c1608d6e0baf80249c42e2be5804) - 1); if ($v867fd4c34db986c640ac965d6b58310c) { if ($v468ba46bbdda22d8ea7081d8068ed7df) { foreach ($v2063c1608d6e0baf80249c42e2be5804 as $v447b7147e84be512208dcc0995d67ebc) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADB; if (is_array($v447b7147e84be512208dcc0995d67ebc)) { $v8b04d5e3775d298e78455efc5ca404d5 = true; foreach ($v447b7147e84be512208dcc0995d67ebc as $v518d8dec3947df909fe6e4c9940f98a6 => $v99ec682294cfb0f1c96b29ac20433cf6) { if ($v8b04d5e3775d298e78455efc5ca404d5) { $v6eedc03a68a69933c763e674f2d7c42f .= AAADA . $v518d8dec3947df909fe6e4c9940f98a6 . AAADE; $v8b04d5e3775d298e78455efc5ca404d5 = false; } else { $v6eedc03a68a69933c763e674f2d7c42f .= "\n" . $v851f5ac9941d720844d143ed9cfcf60a . AAADG . $v518d8dec3947df909fe6e4c9940f98a6 . AAADE; }

if (is_array($v99ec682294cfb0f1c96b29ac20433cf6)) { $v6eedc03a68a69933c763e674f2d7c42f .= "\n" . ffe97cb337457fee1f146f66ba2553637($v99ec682294cfb0f1c96b29ac20433cf6, $v03fdad155b7548884584c7c39b0c5cd2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 + 4, $v4e5868d676cb634aa75b125a0f741abf); } elseif (is_string($v99ec682294cfb0f1c96b29ac20433cf6) && strpos($v99ec682294cfb0f1c96b29ac20433cf6, "\n") !== false) { $v6eedc03a68a69933c763e674f2d7c42f .= " |\n"; $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v99ec682294cfb0f1c96b29ac20433cf6); foreach ($v980da98409d058c365664ff7ea33dd6b as $v6438c669e0d0de98e6929c2cc0fac474) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADJ . $v6438c669e0d0de98e6929c2cc0fac474 . "\n"; }
} else { $v6eedc03a68a69933c763e674f2d7c42f .= AAADA . f8e5b15c74a3fe89571128eb66f54897d($v99ec682294cfb0f1c96b29ac20433cf6) . "\n"; }
}
} else { $v6eedc03a68a69933c763e674f2d7c42f .= AAADA . f8e5b15c74a3fe89571128eb66f54897d($v447b7147e84be512208dcc0995d67ebc) . "\n"; }
}
} else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADB; $v8b04d5e3775d298e78455efc5ca404d5 = true; foreach ($v2063c1608d6e0baf80249c42e2be5804 as $v518d8dec3947df909fe6e4c9940f98a6 => $v99ec682294cfb0f1c96b29ac20433cf6) { if ($v8b04d5e3775d298e78455efc5ca404d5) { $v6eedc03a68a69933c763e674f2d7c42f .= AAADA . $v518d8dec3947df909fe6e4c9940f98a6 . AAADE; $v8b04d5e3775d298e78455efc5ca404d5 = false; } else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADG . $v518d8dec3947df909fe6e4c9940f98a6 . AAADE; }

if (is_array($v99ec682294cfb0f1c96b29ac20433cf6)) { $v6eedc03a68a69933c763e674f2d7c42f .= "\n" . ffe97cb337457fee1f146f66ba2553637($v99ec682294cfb0f1c96b29ac20433cf6, $v03fdad155b7548884584c7c39b0c5cd2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 + 4, $v4e5868d676cb634aa75b125a0f741abf); } elseif (is_string($v99ec682294cfb0f1c96b29ac20433cf6) && strpos($v99ec682294cfb0f1c96b29ac20433cf6, "\n") !== false) { $v6eedc03a68a69933c763e674f2d7c42f .= " |\n"; $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v99ec682294cfb0f1c96b29ac20433cf6); foreach ($v980da98409d058c365664ff7ea33dd6b as $v6438c669e0d0de98e6929c2cc0fac474) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADJ . $v6438c669e0d0de98e6929c2cc0fac474 . "\n"; }
} else { $v6eedc03a68a69933c763e674f2d7c42f .= AAADA . f8e5b15c74a3fe89571128eb66f54897d($v99ec682294cfb0f1c96b29ac20433cf6) . "\n"; }
}
}
} else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . $key . AAADE; if ($v468ba46bbdda22d8ea7081d8068ed7df && $vead60a4fe9e35d6e4f9f3e8ebdf32d02 < $v03fdad155b7548884584c7c39b0c5cd2 * 2) { $v6eedc03a68a69933c763e674f2d7c42f .= "\n"; $v6eedc03a68a69933c763e674f2d7c42f .= ffe97cb337457fee1f146f66ba2553637($v2063c1608d6e0baf80249c42e2be5804, $v03fdad155b7548884584c7c39b0c5cd2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 + 2, $v4e5868d676cb634aa75b125a0f741abf); } else { $v6eedc03a68a69933c763e674f2d7c42f .= "\n"; $v6eedc03a68a69933c763e674f2d7c42f .= ffe97cb337457fee1f146f66ba2553637($v2063c1608d6e0baf80249c42e2be5804, $v03fdad155b7548884584c7c39b0c5cd2, $vead60a4fe9e35d6e4f9f3e8ebdf32d02 + 2, $v4e5868d676cb634aa75b125a0f741abf); }
}
} else { if ($v867fd4c34db986c640ac965d6b58310c) { if (is_string($v2063c1608d6e0baf80249c42e2be5804) && strpos($v2063c1608d6e0baf80249c42e2be5804, "\n") !== false) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . '- |\n'; $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v2063c1608d6e0baf80249c42e2be5804); foreach ($v980da98409d058c365664ff7ea33dd6b as $v6438c669e0d0de98e6929c2cc0fac474) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADG . $v6438c669e0d0de98e6929c2cc0fac474 . "\n"; }
} else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADL . f8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804) . "\n"; }
} else { if (is_string($v2063c1608d6e0baf80249c42e2be5804) && strpos($v2063c1608d6e0baf80249c42e2be5804, "\n") !== false) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . $key . ': |\n'; $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v2063c1608d6e0baf80249c42e2be5804); foreach ($v980da98409d058c365664ff7ea33dd6b as $v6438c669e0d0de98e6929c2cc0fac474) { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . AAADG . $v6438c669e0d0de98e6929c2cc0fac474 . "\n"; }
} else { $v6eedc03a68a69933c763e674f2d7c42f .= $v851f5ac9941d720844d143ed9cfcf60a . $key . AAADM . f8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804) . "\n"; }
}
}
}

return $v6eedc03a68a69933c763e674f2d7c42f; } 


function f8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804) { if (is_null($v2063c1608d6e0baf80249c42e2be5804)) { return AAADO; }

if (is_bool($v2063c1608d6e0baf80249c42e2be5804)) { return $v2063c1608d6e0baf80249c42e2be5804 ? AAADP : AAADR; }

if (is_numeric($v2063c1608d6e0baf80249c42e2be5804)) { return (string)$v2063c1608d6e0baf80249c42e2be5804; }

$v2063c1608d6e0baf80249c42e2be5804 = (string)$v2063c1608d6e0baf80249c42e2be5804; if (preg_match('/[:\[\]{}#&*!|>\'"%@`]/', $v2063c1608d6e0baf80249c42e2be5804) || 
preg_match('/^\s|\s$/', $v2063c1608d6e0baf80249c42e2be5804) ||
in_array(strtolower($v2063c1608d6e0baf80249c42e2be5804), [AAADP, AAADR, AAADO, AAADS, AAADU, AAADW, AAADY])) { return AAADZ . str_replace(AAADZ, AAAEA, $v2063c1608d6e0baf80249c42e2be5804) . AAADZ; }

return $v2063c1608d6e0baf80249c42e2be5804; }



function f57292224bc1db484a36fc6e47f3f71b2($v6eedc03a68a69933c763e674f2d7c42f) { $v980da98409d058c365664ff7ea33dd6b = explode("\n", $v6eedc03a68a69933c763e674f2d7c42f); $vb4a88417b3d0170d754c647c30b7216a = []; $vfac2a47adace059aff113283a03f6760 = [[AAAED => &$vb4a88417b3d0170d754c647c30b7216a, AAAEE => -1]]; $veac22b102a30112d6e74c8dc6af0b915 = -1; $vab0e549d2a8443cc837f6184800edbd4 = null; $vec0650218823d76a3a7b1e31fee1893c = null; $va086100d0950b15b426b1030d740c1fc = null; $v1ef0fe4040450a5ce2ffc5521d618374 = []; $v77cd907dd11c2e6abe84546dd30f33eb = null; 
foreach ($v980da98409d058c365664ff7ea33dd6b as $vc4b559ef1fbd45d771bf4a30dcccd2b7 => $v6438c669e0d0de98e6929c2cc0fac474) { preg_match('/^(\s*)/', $v6438c669e0d0de98e6929c2cc0fac474, $v9c28d32df234037773be184dbdafc274); $vead60a4fe9e35d6e4f9f3e8ebdf32d02 = strlen($v9c28d32df234037773be184dbdafc274[1]); $vc5a4c370532d8090ef6f7e9e0127e9a0 = trim($v6438c669e0d0de98e6929c2cc0fac474); if ($vab0e549d2a8443cc837f6184800edbd4 !== null) { if ($vc5a4c370532d8090ef6f7e9e0127e9a0 === AAACY || $vead60a4fe9e35d6e4f9f3e8ebdf32d02 > $va086100d0950b15b426b1030d740c1fc) { if ($vab0e549d2a8443cc837f6184800edbd4 === AAAEG) { if ($v77cd907dd11c2e6abe84546dd30f33eb === null && $vc5a4c370532d8090ef6f7e9e0127e9a0 !== AAACY) { $v77cd907dd11c2e6abe84546dd30f33eb = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; }

if ($v77cd907dd11c2e6abe84546dd30f33eb !== null && $vead60a4fe9e35d6e4f9f3e8ebdf32d02 >= $v77cd907dd11c2e6abe84546dd30f33eb) { $v1ef0fe4040450a5ce2ffc5521d618374[] = substr($v6438c669e0d0de98e6929c2cc0fac474, $v77cd907dd11c2e6abe84546dd30f33eb); } else { $v1ef0fe4040450a5ce2ffc5521d618374[] = $vc5a4c370532d8090ef6f7e9e0127e9a0; }
} elseif ($vab0e549d2a8443cc837f6184800edbd4 === AAAEI) { $v1ef0fe4040450a5ce2ffc5521d618374[] = $vc5a4c370532d8090ef6f7e9e0127e9a0; }
continue; } else { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED]; if (isset($vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEJ])) { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEJ]; }

if ($vab0e549d2a8443cc837f6184800edbd4 === AAAEG) { $v43b5c9175984c071f30b873fdce0a000[$vec0650218823d76a3a7b1e31fee1893c] = implode("\n", $v1ef0fe4040450a5ce2ffc5521d618374); } else { $v43b5c9175984c071f30b873fdce0a000[$vec0650218823d76a3a7b1e31fee1893c] = implode(AAAEK, $v1ef0fe4040450a5ce2ffc5521d618374); }

$vab0e549d2a8443cc837f6184800edbd4 = null; $vec0650218823d76a3a7b1e31fee1893c = null; $va086100d0950b15b426b1030d740c1fc = null; $v1ef0fe4040450a5ce2ffc5521d618374 = []; $v77cd907dd11c2e6abe84546dd30f33eb = null; }
}

if (trim($v6438c669e0d0de98e6929c2cc0fac474) === AAACY || preg_match('/^\s*#/', $v6438c669e0d0de98e6929c2cc0fac474)) { continue; }

while (count($vfac2a47adace059aff113283a03f6760) > 1 && $vead60a4fe9e35d6e4f9f3e8ebdf32d02 <= $vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEE]) { array_pop($vfac2a47adace059aff113283a03f6760); }

$v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED]; if (preg_match('/^-\s+(.*)$/', $vc5a4c370532d8090ef6f7e9e0127e9a0, $v9c28d32df234037773be184dbdafc274)) { $v9a0364b9e99bb480dd25e1f0284c8555 = $v9c28d32df234037773be184dbdafc274[1]; if (!is_array($v43b5c9175984c071f30b873fdce0a000)) { $v43b5c9175984c071f30b873fdce0a000 = []; }

if (preg_match('/^([a-zA-Z_][a-zA-Z0-9_\s]*?)\s*:\s*(.*)$/', $v9a0364b9e99bb480dd25e1f0284c8555, $ve3a9d482cc1a6e56371b72f814564e5c)) { $key = trim($ve3a9d482cc1a6e56371b72f814564e5c[1]); $v2063c1608d6e0baf80249c42e2be5804 = trim($ve3a9d482cc1a6e56371b72f814564e5c[2]); $v67f83105b67da710b89f767d0c89af66 = []; if ($v2063c1608d6e0baf80249c42e2be5804 === AAAEG || $v2063c1608d6e0baf80249c42e2be5804 === AAAEI) { $vab0e549d2a8443cc837f6184800edbd4 = $v2063c1608d6e0baf80249c42e2be5804; $vec0650218823d76a3a7b1e31fee1893c = $key; $va086100d0950b15b426b1030d740c1fc = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; $v1ef0fe4040450a5ce2ffc5521d618374 = []; $v77cd907dd11c2e6abe84546dd30f33eb = null; $v67f83105b67da710b89f767d0c89af66[$key] = AAACY; } elseif ($v2063c1608d6e0baf80249c42e2be5804 !== AAACY) { $v67f83105b67da710b89f767d0c89af66[$key] = unf8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804); } else { $v67f83105b67da710b89f767d0c89af66[$key] = []; $vfac2a47adace059aff113283a03f6760[] = [AAAED => &$v67f83105b67da710b89f767d0c89af66[$key], AAAEE => $vead60a4fe9e35d6e4f9f3e8ebdf32d02]; }

$v43b5c9175984c071f30b873fdce0a000[] = $v67f83105b67da710b89f767d0c89af66; $vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEJ] = &$v43b5c9175984c071f30b873fdce0a000[count($v43b5c9175984c071f30b873fdce0a000) - 1]; } else { $v43b5c9175984c071f30b873fdce0a000[] = unf8e5b15c74a3fe89571128eb66f54897d($v9a0364b9e99bb480dd25e1f0284c8555); $vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEM] = count($v43b5c9175984c071f30b873fdce0a000) - 1; }

$veac22b102a30112d6e74c8dc6af0b915 = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; continue; }

if ($vead60a4fe9e35d6e4f9f3e8ebdf32d02 > $veac22b102a30112d6e74c8dc6af0b915 && !preg_match(AAAEN, $vc5a4c370532d8090ef6f7e9e0127e9a0) && !preg_match('/^([a-zA-Z_][a-zA-Z0-9_\s]*?)\s*:/', $vc5a4c370532d8090ef6f7e9e0127e9a0)) { if (isset($vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEM])) { $v6f2ee54dde3dc60f4a41e7dfb940851a = $vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEM]; $v43b5c9175984c071f30b873fdce0a000[$v6f2ee54dde3dc60f4a41e7dfb940851a] .= AAADA . $vc5a4c370532d8090ef6f7e9e0127e9a0; continue; }
}

if (preg_match('/^([^:]+):\s*(.*)$/', $vc5a4c370532d8090ef6f7e9e0127e9a0, $v9c28d32df234037773be184dbdafc274)) { $key = trim($v9c28d32df234037773be184dbdafc274[1]); $v2063c1608d6e0baf80249c42e2be5804 = trim($v9c28d32df234037773be184dbdafc274[2]); if (isset($vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEJ])) { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEJ]; }

if (!is_array($v43b5c9175984c071f30b873fdce0a000)) { $v43b5c9175984c071f30b873fdce0a000 = []; }

if ($v2063c1608d6e0baf80249c42e2be5804 === AAAEG || $v2063c1608d6e0baf80249c42e2be5804 === AAAEI) { $vab0e549d2a8443cc837f6184800edbd4 = $v2063c1608d6e0baf80249c42e2be5804; $vec0650218823d76a3a7b1e31fee1893c = $key; $va086100d0950b15b426b1030d740c1fc = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; $v1ef0fe4040450a5ce2ffc5521d618374 = []; $v77cd907dd11c2e6abe84546dd30f33eb = null; $v43b5c9175984c071f30b873fdce0a000[$key] = AAACY; } elseif ($v2063c1608d6e0baf80249c42e2be5804 !== AAACY) { $v43b5c9175984c071f30b873fdce0a000[$key] = unf8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804); } else { if (!isset($v43b5c9175984c071f30b873fdce0a000[$key])) { $v43b5c9175984c071f30b873fdce0a000[$key] = []; }
$vfac2a47adace059aff113283a03f6760[] = [AAAED => &$v43b5c9175984c071f30b873fdce0a000[$key], AAAEE => $vead60a4fe9e35d6e4f9f3e8ebdf32d02]; }

$veac22b102a30112d6e74c8dc6af0b915 = $vead60a4fe9e35d6e4f9f3e8ebdf32d02; }
}

if ($vab0e549d2a8443cc837f6184800edbd4 !== null) { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAED]; if (isset($vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEJ])) { $v43b5c9175984c071f30b873fdce0a000 = &$vfac2a47adace059aff113283a03f6760[count($vfac2a47adace059aff113283a03f6760) - 1][AAAEJ]; }

if ($vab0e549d2a8443cc837f6184800edbd4 === AAAEG) { $v43b5c9175984c071f30b873fdce0a000[$vec0650218823d76a3a7b1e31fee1893c] = implode("\n", $v1ef0fe4040450a5ce2ffc5521d618374); } else { $v43b5c9175984c071f30b873fdce0a000[$vec0650218823d76a3a7b1e31fee1893c] = implode(AAAEK, $v1ef0fe4040450a5ce2ffc5521d618374); }
}

return $vb4a88417b3d0170d754c647c30b7216a; }


function unf8e5b15c74a3fe89571128eb66f54897d($v2063c1608d6e0baf80249c42e2be5804) { $v2063c1608d6e0baf80249c42e2be5804 = trim($v2063c1608d6e0baf80249c42e2be5804); if ($v2063c1608d6e0baf80249c42e2be5804 === AAADO || $v2063c1608d6e0baf80249c42e2be5804 === AAAEP || $v2063c1608d6e0baf80249c42e2be5804 === AAACY) { return null; }

if (in_array(strtolower($v2063c1608d6e0baf80249c42e2be5804), [AAADP, AAADS, AAADW])) { return true; }
if (in_array(strtolower($v2063c1608d6e0baf80249c42e2be5804), [AAADR, AAADU, AAADY])) { return false; }

if ((substr($v2063c1608d6e0baf80249c42e2be5804, 0, 1) === AAAER && substr($v2063c1608d6e0baf80249c42e2be5804, -1) === AAAER) ||
(substr($v2063c1608d6e0baf80249c42e2be5804, 0, 1) === AAADZ && substr($v2063c1608d6e0baf80249c42e2be5804, -1) === AAADZ)) { $v2063c1608d6e0baf80249c42e2be5804 = substr($v2063c1608d6e0baf80249c42e2be5804, 1, -1); if (strpos($v2063c1608d6e0baf80249c42e2be5804, AAAEA) !== false) { $v2063c1608d6e0baf80249c42e2be5804 = str_replace(AAAEA, AAADZ, $v2063c1608d6e0baf80249c42e2be5804); }
return $v2063c1608d6e0baf80249c42e2be5804; }

if (is_numeric($v2063c1608d6e0baf80249c42e2be5804)) { return strpos($v2063c1608d6e0baf80249c42e2be5804, AAAEU) !== false ? (float)$v2063c1608d6e0baf80249c42e2be5804 : (int)$v2063c1608d6e0baf80249c42e2be5804; }

return $v2063c1608d6e0baf80249c42e2be5804; }

}?>