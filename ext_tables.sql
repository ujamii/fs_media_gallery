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
