#
# Table structure for table 'sys_file_collection'
#
CREATE TABLE sys_file_collection (
	datetime int(11) DEFAULT '0' NOT NULL,
	parentalbum int(11) DEFAULT '0' NOT NULL,
	webdescription text NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	KEY parentalbum (parentalbum)
);

#
# Table structure for table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (
	related_fsmediaalbums int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_news_domain_model_news_fsmediaalbums_mm'
#
CREATE TABLE tx_news_domain_model_news_fsmediaalbums_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
