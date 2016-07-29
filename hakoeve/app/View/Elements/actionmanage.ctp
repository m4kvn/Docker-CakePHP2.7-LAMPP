<?php echo $this->Html->css('actionmanage') ?>
<?php echo $this->Html->css('lksMenuSkin2') ?>

<?php echo $this->Html->script('jquery.lksMenu');?>

<script>
	$('document').ready(function(){
	    $('.menu').lksMenu();
	});
</script>
<div class="manage_menu">
<div class="menu_tittle">管理メニュー</div>
	<div class="menu">

        <ul>
            <li>
                <a>イベント管理</a>
                <ul>
                    <li><a href="/../hakoeve/events/manage">イベント一覧</a></li>
                    <li><a href="/../hakoeve/events/add">イベント追加</a></li>
                </ul>
            </li>
            <li>
                <a>タグ管理</a>
                <ul>
                    <li><a href="/../hakoeve/tags/manage">タグ一覧</a></li>
                    <li><a href="/../hakoeve/tags/add">タグ追加</a></li>
                </ul>
            </li>
            <li>
                <a>開催場所管理</a>
                <ul>
                    <li><a href="/../hakoeve/venues">開催場所一覧</a></li>
                    <li><a href="/../hakoeve/venues/add">開催場所追加</a></li>
                </ul>
            <li>
                <a>主催者管理</a>
                <ul>
                    <li><a href="/../hakoeve/hosts">主催者一覧</a></li>
                    <li><a href="/../hakoeve/hosts/add">主催者追加</a></li>    
                </ul>
            </li>
            <li>
                <a href="/../hakoeve/users/logout">ログアウト</a>
            </li>
        </ul>
    </div>


</div>