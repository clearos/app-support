
Name: app-support
Epoch: 1
Version: 2.1.6
Release: 1%{dist}
Summary: Support
License: GPLv3
Group: ClearOS/Apps
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base

%description
Options and resources for supporting your system.  If you would like to discuss your requirements, please <a href="#" class="support-contact">contact us</a>.

%package core
Summary: Support - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-clearcenter

%description core
Options and resources for supporting your system.  If you would like to discuss your requirements, please <a href="#" class="support-contact">contact us</a>.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/support
cp -r * %{buildroot}/usr/clearos/apps/support/

install -D -m 0644 packaging/support.conf %{buildroot}/etc/clearos/support.conf

%post
logger -p local6.notice -t installer 'app-support - installing'

%post core
logger -p local6.notice -t installer 'app-support-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/support/deploy/install ] && /usr/clearos/apps/support/deploy/install
fi

[ -x /usr/clearos/apps/support/deploy/upgrade ] && /usr/clearos/apps/support/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-support - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-support-core - uninstalling'
    [ -x /usr/clearos/apps/support/deploy/uninstall ] && /usr/clearos/apps/support/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/support/controllers
/usr/clearos/apps/support/htdocs
/usr/clearos/apps/support/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/support/packaging
%dir /usr/clearos/apps/support
/usr/clearos/apps/support/deploy
/usr/clearos/apps/support/language
/usr/clearos/apps/support/libraries
%config(noreplace) /etc/clearos/support.conf
