Name:		adminer-elasticsearch
Version:	4.3.0
Release:	1%{?dist}
Summary:	Adminer Elasticsearch
BuildRoot:	%{_topdir}/BUILD/%{name}-%{version}-%{release}
BuildArch:	noarch
Group:		System Environment/Base
License:	GPL2/Apache License
Source0:	%{name}-%{version}.tar.gz
Requires:	app-base-core

%description
Adminer configured to connect to local Elasticsearch system.

%prep
%setup -q

%build

%install
mkdir -p $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch
mkdir -p $RPM_BUILD_ROOT/usr/clearos/sandbox/etc/httpd/conf.d

install -m 0644 adminer-elasticsearch.conf $RPM_BUILD_ROOT/usr/clearos/sandbox/etc/httpd/conf.d
install -m 0644 adminer-4.3.0.php $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/

cp -av docroot $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/
cp -av plugins $RPM_BUILD_ROOT/usr/share/adminer-elasticsearch/

%clean
rm -rf $RPM_BUILD_ROOT

%files
%attr(-,root,root)
%doc gpl-2.0.txt LICENSE-2.0.txt
%dir /usr/share/adminer-elasticsearch
/usr/share/adminer-elasticsearch/adminer-4.3.0.php
/usr/share/adminer-elasticsearch/docroot
/usr/share/adminer-elasticsearch/plugins
/usr/clearos/sandbox/etc/httpd/conf.d/adminer-elasticsearch.conf

%changelog
* Mon Apr 03 2017 eGloo <developer@egloo.ca> 4.3.0
- First build
