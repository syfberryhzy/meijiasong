@servers(['web' => 'root@119.23.18.36'])

@task('deploy')
    cd /data/www/meijiasong.mandokg.com
    git pull origin master
@endtask
