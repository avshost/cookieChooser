# cookieChooser
Wordpress plugin that allows you to create a cookie based on a dropdown menu choice

To use this plugin, put a short tag in a post or page. This will create a dropdown select box. In the short tag, there is a specific format to create the dropdown:
[chooser 					... REQUIRED This is the name of the shortag
name="[ANY NAME YOU WANT]" 			... REQUIRED This is the name of the dropdown 
							box and the base of the name for the 
							cookies that will be set.
options="DisplayText2:value|DisplayText2:value"	... REQUIRED This is a list of options that will
							be displayed in the dropdown box.

When an option is selected, there are two cookies that are set:
* nameOfDropdown-text - Contains the DisplayText from the option
* nameOfDropdown-value - Contains the value from the option

When a person reloads the page, the last chosen DisplayText is set in the dropdown. This is because the value can often be the same for multiple display texts, but the Display text should probably always be unique.


Example usage:
[chooser name="storeCookie" options=":blank|Apple Valley:full|Eagan:full|East Bloomington:full|Savage:full|West Bloomington:full|Maple Grove:flex|Savage Express:express"]
