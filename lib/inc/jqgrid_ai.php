<?php

// set default ai interface language
if (!defined("AI_LANG"))
	define("AI_LANG","EN");

class ai_grid
{
	static $mode = "";
	static $key = AI_APIKEY;
	static $url = AI_ENDPOINT;
	static $model = AI_MODEL;

	static function ask_groq($prompt, $extra = array()) {

		// if empty api, return error
		if (empty(ai_grid::$key) || empty(ai_grid::$url) || empty(ai_grid::$model)) {
			return json_encode(array(
				"error" => array(
					"code" => "invalid_api_key",
					"message" => "Please enter a valid AI API endpoint, API key and model in the config file."
				)
			));
		}

		// override if using other openai end point
		$api_key = ai_grid::$key;
		$api_url = ai_grid::$url;

		$post_data = [
			"model" => ai_grid::$model,
			"messages" => [["role" => "user", "content" => $prompt]],
			"temperature" => 1,
			"max_completion_tokens" => 8192,
			"top_p" => 1,
			// "seed" => 300,
			"stop" => null
		];

		if (ai_grid::$mode == "json")
			$post_data["response_format"] = ["type"=>"json_object"];

		// merge passed data with post
		$post_data = array_merge($post_data,$extra);

		$post_fields = json_encode($post_data);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Content-Type: application/json",
			"Authorization: Bearer $api_key"
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

		// Ignore SSL Verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$response = curl_exec($ch);
		curl_close($ch);

		error_log("ask_groq reponse:".$response);
		
		// simulating error
		// $response = '{"error":{"message":"Failed to generate JSON. Please adjust your prompt. See \'failed_generation\' for more details.","type":"invalid_request_error","code":"json_validate_failed","failed_generation":"{   \"results:{       \"sql\": \"SELECT c.contac_title, COUNT(c.contac_title) as frequency FROM customers c WHERE 1=1 GROUP BY c.contac_title ORDER BY frequency DESC LIMIT 10\",       \"explanation\": \"This query selects the contact_title from the customers table, counts the occurrences of each contact_title, and orders the results in descending order by frequency. The LIMIT 10 clause restricts the output to the top 10 most frequent contact titles.\"   }"}}';
		
		// return json_decode($response, true)["choices"][0]["message"]["content"] ?? json_decode($response, true)["error"]["message"];
		$content = json_decode($response, true)["choices"][0]["message"]["content"];
		return !empty($content) ? $content : $response;
	}

	static function make_json_readable($json, $question) {

		// if no json data input, don't make ai query
		if (empty(json_decode($json,true)))
		{
			$result = new stdClass();
			$result->error = "empty json input";
			// make error user friendly
			ai_grid::filter_error($result);
			return $result;		
		}

		$prompt = "
You are a database architect and business analyst.
You need to convert JSON data to human readable reponse based on the question.

Initial Question was: 
----
$question
----

Json data from database:
----
$json.  
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
{
	'result': { 
		'text': '{ai-response}' 
		}
}";

		ai_grid::$mode = "json";

		error_log("make_json_readable:".$prompt);

		$result = ai_grid::ask($prompt);
		error_log("make_json_readable output:".($result));

		$result = json_decode($result);

		// make error user friendly
		if ($result->error || $result->errors) 
			ai_grid::filter_error($result);

		return $result;		
	}

	static function summarize_csv_with_groq($csv_string) {

		$rows = array_map("str_getcsv", explode("\n", $csv_string));
		$header = array_shift($rows);

		$data = [];
		foreach ($rows as $row) {
			if (count($row) == count($header)) {
				$data[] = array_combine($header, $row);
			}
		}

		$json_data = json_encode($data, JSON_PRETTY_PRINT);
		$prompt = "Summarize the following CSV file :\n\n$json_data";
		return ai_grid::ask($prompt);
	}

	static function ask($prompt,$extra = array())
	{
		// only provide right now
		return ai_grid::ask_groq($prompt,$extra);
	}

	static function extract_json($response) {
		
		error_log("extract_json:".$response);

		// Use regex to find JSON inside the response
		preg_match('~\{(?:[^{}]|(?R))*\}~', $response, $matches);
		return !empty($matches[0]) ? $matches[0] : "Error: No valid JSON found";
	}


	static function ask_json($prompt)
	{
		$prompt = "$prompt

Output Instructions
-------------------
- Only response in sample output format with no additional text, hallucination and mutations. 

Sample Output JSON
------------------
{
output: 'response'
}
";	

		$result = ai_grid::ask($prompt);

		// remove ``` if any
		$result = str_replace("```json","",$result);
		$result = str_replace("```","",$result);
		return $result;
	}
		
	// Not used now
	static function get_json_filters_by_nlp($fields,$table,$question)
	{
		$prompt = "Using following sql table '$table' and fields '$fields',
					Convert the following natural language query into structured JSON as well as SQL query:
					Query: '$question'. 
					Return the WHERE clause & ORDER BY clause output in ONLY this JSON format:
					{ 'filters': [\n  {\"field\": \"field_name\", \"op\": \"op\", \"data\": \"value\"},\n  {\"field\": \"field_name\", \"op\": \"op\", \"data\": \"value\"}\n], 'order':{\"field\": \"field_name\", \"sort\": \"sort_order\"}, 'explanation':'short text explaining the filters conditions and prefix with (Filtering ...). Don't tell about sorting.'}.
					'op' in json can be one of these: <,<=,>,>=,=,!=,like.
					Don't return % in json data for like query.
					For single term, always use like operator.
					Try to find the single term in all possible table fields.
					Don't use database field name and terms in explanation, Use user friendly name.
					If no field is found, search all fields with like operator for the term.
					";

		$result = ai_grid::ask($prompt);
		// phpgrid_error($result);
		return ai_grid::extract_json($result);
	}

	static function get_insights($fields,$sql,$question)
	{
		$db = PHPGRID_DBTYPE;
		$prompt = "
You are a business analyst and a database architect.
Convert the following natural language query into SQL Query compatible with $db latest version.
Query: '$question'.

Understanding the database schema from following sql query: 
---
$sql
---
and fields: '$fields',

Instructions:
Keep table alias and joins as it source sql. 
Also use fields with table name alias. 
Only use these fields and don't assume any new field. 
If there are entity id and name both present in fields, try to show result with name.
For multiple records in result, limit sql query to best 10 records and prefer giving aggregate result.
Round off numeric values to zero places and don't mention in explanation.
Return json only in following format with no extra text or hallucination: 
------
{
	'results':
	[
		{'sql':'{SQL-QUERY}','explanation':'{SQL-QUERY-EXPLANATION}'},
		{'sql':'{SQL-QUERY}','explanation':'{SQL-QUERY-EXPLANATION}'}
	]
} 
";

		error_log("get_insight:".$prompt);
		
		ai_grid::$mode = "json";
		$result = ai_grid::ask($prompt);
		
		error_log("get_insight output:".$result);
		$result = json_decode($result);

		// make error user friendly
		if ($result->error || $result->errors) 
			ai_grid::filter_error($result);

		return $result;
	}

	static function suggest_questions($fields,$sql)
	{
		$prompt = "
You are a business analyst and a database architect.
By understanding following sql query: 
---
$sql
---
and fields: '$fields',
Suggest the questions that can be asked to summarize the data.
Don't suggest question which needs an input.
Don't suggest question where expected response is large text.
Limit to 5 questions.
Give your questions in ".AI_LANG." langauge.
Return json only in following format with no extra text and assumption: 
{
	'results':
		[
			{'question':'{ai-question-content}'},
			{'question':'{ai-question-content}'}
		]
}";

		error_log("suggest_questions:".$prompt);

		ai_grid::$mode = "json";
		$result = ai_grid::ask($prompt);
		$result = json_decode($result);

		// make error user friendly
		if ($result->error || $result->errors) 
			ai_grid::filter_error($result);

		return $result;
	}

	static function filter_error(&$response)
	{		
		if (empty($response->error))
			$response->error = $response->errors[0];

		if ($response->error)
		{
			if ($response->error->code == "invalid_api_key")
				$response->error = "Please enter a valid AI api endpoint, key and model in the config file.";
			else if ($response->error->code == "10000")
				$response->error = "Please enter a valid AI api key, Authentication error.";
			else
				$response->error = "We're unable to generate response at this time. Please try again.";
		}
	}
}

if (!defined("yaml_to_array") && !defined("array_to_yaml"))
{
	/**
	 * Simplified YAML Dumper (inspired by Symfony approach)
	 * Converts PHP array to YAML string
	 */
	function array_to_yaml($array, $inline = 2, $indent = 0, $flags = 0) {
		$yaml = '';
		$prefix = str_repeat(' ', $indent);
		
		foreach ($array as $key => $value) {
				$isIndexed = is_int($key);
				
				if (is_array($value) && !empty($value)) {
						$isSequence = array_keys($value) === range(0, count($value) - 1);
						
						if ($isIndexed) {
								// List item
								if ($isSequence) {
										// Array of arrays (like forms or reports)
										foreach ($value as $item) {
												$yaml .= $prefix . '-';
												if (is_array($item)) {
														$first = true;
														foreach ($item as $subKey => $subValue) {
																if ($first) {
																		$yaml .= ' ' . $subKey . ':';
																		$first = false;
																} else {
																		$yaml .= "\n" . $prefix . '	' . $subKey . ':';
																}
																
																if (is_array($subValue)) {
																		$yaml .= "\n" . array_to_yaml($subValue, $inline, $indent + 4, $flags);
																} elseif (is_string($subValue) && strpos($subValue, "\n") !== false) {
																		// Handle multiline strings with literal style
																		$yaml .= " |\n";
																		$lines = explode("\n", $subValue);
																		foreach ($lines as $line) {
																				$yaml .= $prefix . '		' . $line . "\n";
																		}
																} else {
																		$yaml .= ' ' . escape_yaml_value($subValue) . "\n";
																}
														}
												} else {
														$yaml .= ' ' . escape_yaml_value($item) . "\n";
												}
										}
								} else {
										// Single associative array as list item
										$yaml .= $prefix . '-';
										$first = true;
										foreach ($value as $subKey => $subValue) {
												if ($first) {
														$yaml .= ' ' . $subKey . ':';
														$first = false;
												} else {
														$yaml .= $prefix . '	' . $subKey . ':';
												}
												
												if (is_array($subValue)) {
														$yaml .= "\n" . array_to_yaml($subValue, $inline, $indent + 4, $flags);
												} elseif (is_string($subValue) && strpos($subValue, "\n") !== false) {
														// Handle multiline strings with literal style
														$yaml .= " |\n";
														$lines = explode("\n", $subValue);
														foreach ($lines as $line) {
																$yaml .= $prefix . '		' . $line . "\n";
														}
												} else {
														$yaml .= ' ' . escape_yaml_value($subValue) . "\n";
												}
										}
								}
						} else {
								// Named key with array value
								$yaml .= $prefix . $key . ':';
								
								if ($isSequence && $indent < $inline * 2) {
										// Inline sequence
										$yaml .= "\n";
										$yaml .= array_to_yaml($value, $inline, $indent + 2, $flags);
								} else {
										$yaml .= "\n";
										$yaml .= array_to_yaml($value, $inline, $indent + 2, $flags);
								}
						}
				} else {
						// Scalar value
						if ($isIndexed) {
								if (is_string($value) && strpos($value, "\n") !== false) {
										// Handle multiline strings in list items with literal style
										$yaml .= $prefix . '- |\n';
										$lines = explode("\n", $value);
										foreach ($lines as $line) {
												$yaml .= $prefix . '	' . $line . "\n";
										}
								} else {
										$yaml .= $prefix . '- ' . escape_yaml_value($value) . "\n";
								}
						} else {
								if (is_string($value) && strpos($value, "\n") !== false) {
										// Handle multiline strings with literal style
										$yaml .= $prefix . $key . ': |\n';
										$lines = explode("\n", $value);
										foreach ($lines as $line) {
												$yaml .= $prefix . '	' . $line . "\n";
										}
								} else {
										$yaml .= $prefix . $key . ': ' . escape_yaml_value($value) . "\n";
								}
						}
				}
		}
		
		return $yaml;
	} 

	/**
	* Escape YAML values (handle special characters and quoting)
	*/
	function escape_yaml_value($value) {
		if (is_null($value)) {
				return 'null';
		}
		
		if (is_bool($value)) {
				return $value ? 'true' : 'false';
		}
		
		if (is_numeric($value)) {
				return (string)$value;
		}
		
		$value = (string)$value;
		
		// Check if value needs quoting
		if (preg_match('/[:\[\]{}#&*!|>\'"%@`]/', $value) || 
				preg_match('/^\s|\s$/', $value) ||
				in_array(strtolower($value), ['true', 'false', 'null', 'yes', 'no', 'on', 'off'])) {
				// Use single quotes and escape existing single quotes
				return "'" . str_replace("'", "''", $value) . "'";
		}
		
		return $value;
	}

	/**
	* Simplified YAML Parser (inspired by Symfony approach)
	* Converts YAML string to PHP array
	*/

	function yaml_to_array($yaml) {
		$lines = explode("\n", $yaml);
		$result = [];
		$stack = [['data' => &$result, 'indent' => -1]];
		$currentIndent = -1;
		$multilineMode = null;
		$multilineKey = null;
		$multilineIndent = null;
		$multilineContent = [];
		$multilineContentIndent = null; // Track the content indentation
		
		foreach ($lines as $lineNum => $line) {
				// Calculate indentation
				preg_match('/^(\s*)/', $line, $matches);
				$indent = strlen($matches[1]);
				$trimmedLine = trim($line);
				
				// Handle multiline content
				if ($multilineMode !== null) {
						// Check if we're still in multiline content
						if ($trimmedLine === '' || $indent > $multilineIndent) {
								// Add line to multiline content
								if ($multilineMode === '|') {
										// Literal style - preserve line breaks
						// On first content line, establish the base indentation
						if ($multilineContentIndent === null && $trimmedLine !== '') {
							$multilineContentIndent = $indent;
						}
						
						// Strip the established content indentation
						if ($multilineContentIndent !== null && $indent >= $multilineContentIndent) {
							$multilineContent[] = substr($line, $multilineContentIndent);
						} else {
							// Empty line or less indented (shouldn't happen in valid YAML)
							$multilineContent[] = $trimmedLine;
						}
								} elseif ($multilineMode === '>') {
										// Folded style - join lines
										$multilineContent[] = $trimmedLine;
								}
								continue;
						} else {
								// End of multiline content
								$current = &$stack[count($stack) - 1]['data'];
								if (isset($stack[count($stack) - 1]['lastItem'])) {
										$current = &$stack[count($stack) - 1]['lastItem'];
								}
								
								if ($multilineMode === '|') {
										$current[$multilineKey] = implode("\n", $multilineContent);
								} else {
										$current[$multilineKey] = implode(" ", $multilineContent);
								}
								
								$multilineMode = null;
								$multilineKey = null;
								$multilineIndent = null;
								$multilineContent = [];
					$multilineContentIndent = null;
								// Continue processing this line
						}
				}
				
				// Skip empty lines and comments (when not in multiline mode)
				if (trim($line) === '' || preg_match('/^\s*#/', $line)) {
						continue;
				}
				
				// Pop stack if we've decreased indentation
				while (count($stack) > 1 && $indent <= $stack[count($stack) - 1]['indent']) {
						array_pop($stack);
				}
				
				$current = &$stack[count($stack) - 1]['data'];
				
				// Handle list items (starting with -)
				if (preg_match('/^-\s+(.*)$/', $trimmedLine, $matches)) {
						$content = $matches[1];
						
						// Ensure current context is an array
						if (!is_array($current)) {
								$current = [];
						}
						
				// Check if this is a valid YAML key:value pair
						if (preg_match('/^([a-zA-Z_][a-zA-Z0-9_\s]*?)\s*:\s*(.*)$/', $content, $kvMatches)) {
						// List item with key:value
								$key = trim($kvMatches[1]);
								$value = trim($kvMatches[2]);
								
								$newItem = [];
								
								// Check for multiline indicator
								if ($value === '|' || $value === '>') {
										$multilineMode = $value;
										$multilineKey = $key;
										$multilineIndent = $indent;
										$multilineContent = [];
						$multilineContentIndent = null;
										$newItem[$key] = '';
								} elseif ($value !== '') {
										$newItem[$key] = unescape_yaml_value($value);
								} else {
										$newItem[$key] = [];
										$stack[] = ['data' => &$newItem[$key], 'indent' => $indent];
								}
								
								$current[] = $newItem;
								$stack[count($stack) - 1]['lastItem'] = &$current[count($current) - 1];
						} else {
								// Simple list item (including SQL statements with colons)
								$current[] = unescape_yaml_value($content);
								// Mark this as the last list item for potential continuation lines
								$stack[count($stack) - 1]['lastListItemIndex'] = count($current) - 1;
						}
						
						$currentIndent = $indent;
						continue;
				}
				
			// Handle continuation lines
				if ($indent > $currentIndent && !preg_match('/^-/', $trimmedLine) && !preg_match('/^([a-zA-Z_][a-zA-Z0-9_\s]*?)\s*:/', $trimmedLine)) {
						// This is a continuation of the previous list item
						if (isset($stack[count($stack) - 1]['lastListItemIndex'])) {
								$lastIndex = $stack[count($stack) - 1]['lastListItemIndex'];
								// Append to the last list item with a space
								$current[$lastIndex] .= ' ' . $trimmedLine;
								continue;
						}
				}
				
				// Handle key:value pairs
				if (preg_match('/^([^:]+):\s*(.*)$/', $trimmedLine, $matches)) {
						$key = trim($matches[1]);
						$value = trim($matches[2]);
						
						// Check if we're inside a list item
						if (isset($stack[count($stack) - 1]['lastItem'])) {
								$current = &$stack[count($stack) - 1]['lastItem'];
						}
						
						if (!is_array($current)) {
								$current = [];
						}
						
						// Check for multiline indicator
						if ($value === '|' || $value === '>') {
								$multilineMode = $value;
								$multilineKey = $key;
								$multilineIndent = $indent;
								$multilineContent = [];
					$multilineContentIndent = null;
								$current[$key] = '';
						} elseif ($value !== '') {
								// Key with inline value
								$current[$key] = unescape_yaml_value($value);
						} else {
								// Key with nested content
								if (!isset($current[$key])) {
										$current[$key] = [];
								}
								$stack[] = ['data' => &$current[$key], 'indent' => $indent];
						}
						
						$currentIndent = $indent;
				}
		}
		
		// Handle any remaining multiline content
		if ($multilineMode !== null) {
				$current = &$stack[count($stack) - 1]['data'];
				if (isset($stack[count($stack) - 1]['lastItem'])) {
						$current = &$stack[count($stack) - 1]['lastItem'];
				}
				
				if ($multilineMode === '|') {
						$current[$multilineKey] = implode("\n", $multilineContent);
				} else {
						$current[$multilineKey] = implode(" ", $multilineContent);
				}
		}
		
		return $result;
	}

	/**
	* Unescape YAML values
	*/
	function unescape_yaml_value($value) {
		$value = trim($value);
		
		// Handle null
		if ($value === 'null' || $value === '~' || $value === '') {
				return null;
		}
		
		// Handle booleans
		if (in_array(strtolower($value), ['true', 'yes', 'on'])) {
				return true;
		}
		if (in_array(strtolower($value), ['false', 'no', 'off'])) {
				return false;
		}
		
		// Handle quoted strings
		if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
				(substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
				$value = substr($value, 1, -1);
				if (strpos($value, "''") !== false) {
						$value = str_replace("''", "'", $value);
				}
				return $value;
		}
		
		// Handle numbers
		if (is_numeric($value)) {
				return strpos($value, '.') !== false ? (float)$value : (int)$value;
		}
		
		return $value;
	}
	
}