Name:       adminer-elasticsearch
Version:    4.7.0
Release:    2%{?dist}
Summary:    Adminer Elasticsearch
BuildRoot:  %{_topdir}/BUILD/%{name}-%{version}-%{release}
BuildArch:  noarch
Group:      System Environment/Base
License:    GPL2/Apache License
Source0:    adminer-%{version}.tar.gz
Source1:    adminer-elasticsearch.conf
Source2:    adminer.css
Source3:    adminer-index.php
Source4:    adminer-elasticsearch.php
Requires:   app-base-core
Requires:   app-elasticsearch-core
Requires:   app-elasticsearch-plugin-core
BuildRequires: php-cli

%description
Adminer configured to connect to local Elasticsearch system.

%prep
%setup -q -n adminer-%{version}

%build
./compile.php

%install
mkdir -p $RPM_BUILD_ROOT/usr/clearos/sandbox/etc/httpd/conf.d
mkdir -p $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/docroot
mkdir -p $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/plugins

install -m 0644 %{SOURCE1} $RPM_BUILD_ROOT/usr/clearos/sandbox/etc/httpd/conf.d
install -m 0644 adminer-%{version}.php $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/adminer.php

install -m 0644 %{SOURCE2} $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/docroot/adminer.css
install -m 0644 %{SOURCE3} $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/docroot/index.php
install -m 0644 %{SOURCE4} $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/plugins/elasticsearch.php
install -m 0644 plugins/plugin.php $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/plugins/

%clean
rm -rf $RPM_BUILD_ROOT

%files
%attr(-,root,root)
%dir /usr/share/adminer-elasticsearch
/usr/share/adminer-elasticsearch/adminer.php
/usr/share/adminer-elasticsearch/docroot
/usr/share/adminer-elasticsearch/plugins
/usr/clearos/sandbox/etc/httpd/conf.d/adminer-elasticsearch.conf

%changelog
* Mon Jan 07 2019 @manasoft <ngudiamanasse@gmail.com> 4.7.0
- 4.7.0 - update to Adminer 4.7.0

* Sun Oct 14 2018 @manasoft <ngudiamanasse@gmail.com> 4.6.3
- 4.6.3 - update to latest stable Adminer

* Wed Apr 25 2018 eGloo <developer@egloo.ca> 4.6.2
- 4.6.2 - previous patch was merged with upstream

* Tue May 23 2017 eGloo <developer@egloo.ca> 4.3.1
- 4.3.1 with patch for ElasticSearch 5.4

* Mon Apr 03 2017 eGloo <developer@egloo.ca> 4.3.0
- First build
