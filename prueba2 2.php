function exect($array, $column = '')
{

	if(is_array($array))
	{
		foreach (array_keys($array) as $key => $value) {
			exect($array[$value], $value);
			$tab = '';
		}
	}
	else
	{
		echo $column.'&nbsp;&nbsp;['.$array.']<br>';
	}
}
