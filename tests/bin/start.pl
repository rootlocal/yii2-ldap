#!/usr/bin/env perl

use strict;
use warnings;
use Cwd qw(abs_path);
use FindBin qw($RealBin);
use Data::Dumper;

my $path = abs_path($0);
#print Dumper \$path;
#print Dumper  \$RealBin;
#print Dumper \$ENV{'PWD'};

my $osname = $^O;
my $rc_file;

if( $osname eq 'darwin' ){{
        $rc_file="slapd_macos.sh"
    }}
if( $osname eq 'freebsd' ){{
        $rc_file="slapd_freebsd.sh"
    }}

my @args = ("cd $RealBin/../ && /bin/sh -c ./bin/$rc_file > /dev/null > /dev/null 2>&1");
system(@args) == 0
    or die "system @args failed: $?";

if ($? == -1) {
    print "failed to execute: $!\n";
}
elsif ($? & 127) {
    printf "child died with signal %d, %s coredump\n",
    ($? & 127),  ($? & 128) ? 'with' : 'without';
}
else {
    printf "child exited with value %d\n", $? >> 8;
}
