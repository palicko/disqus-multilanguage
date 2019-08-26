/**
 * Add custom Disqus config and load Disqus in proper language.
 */
var disqus_config = function () {
	var lang = disqus_multilanguage.language;

	// Disqus needs 'cs' slug for CZ language, change it!
	if (lang === 'cz') {
		lang = 'cs';
	}

	this.language = lang;
};
