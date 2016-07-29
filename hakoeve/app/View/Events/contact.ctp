<?php echo $this->Html->css('contact');?>


<div class="contact">
	<?php if((!isset($Contact) && !isset($Confirm))|| isset($Back)){ ?>
		<div>
			<div class="contact_title">お問い合わせ</div>
			<div>

				<div class="contact_subtitle">よくある質問</div>
				<div class="QandA_space">
					<div class="QandA">
						<div class="contextQ">イベントを登録したいのですが、どうすればいいのでしょうか？</div>
						<div class="contextA">画面上部の「イベント登録したい方はこちら」をクリックしていただくと、<br/>　イベント登録申請のページに移動します<br>
							&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://hakomachi.com/hakoeve/events/about_add">イベント登録したい方はこちら</a>
						</div>
					</div>
					<br/>
					<div class="QandA">
						<div class="contextQ">過去に行われたイベントを確認したいのですが、<br/>　どうすればいいのでしょうか？</div>
						<div class="contextA">画面上部の「日付から探す」のタブをクリックし、<br/>　そこから過去の日付を指定して検索をしてください</div>
					</div>
					<br/>
					<div class="QandA">
						<div class="contextQ">このサイトのリンクを貼りたいのですが、よろしいですか？</div>
						<div class="contextA">はい。このサイトはリンクフリーです。<br/>　リンクを貼る際には、<a href="http://hakomachi.com/hakoeve/events/about">HakoEveとは</a>　を参考にしてください</div>
					</div>
				</div>

				<div>
					<div class="contact_subtitle">お問い合せはこちら</div>
						<?php	echo $this->Form->create('Contact');	?>

					<table>
						<tr>
							<td class="left"><div class="captoin">お名前</div><div class="small_caption">全角で入力してください</div></td>
							<td class="right">
								<?php echo $this->Form->text("Name", array("placeholder" => "お名前を入力してください"));
									echo $this->Form->error("Contact.Name");	?>
							</td>
						</tr>
						<tr>
							<td class="left"><div class="captoin">メールアドレス</div><div class="small_caption">半角英数字で入力してください</div></td>
							<td class="right">
								<?php echo $this->Form->text("MailAddress", array("placeholder" => "返信先メールアドレスを入力してください"));
									echo $this->Form->error("Contact.MailAddress"); ?>
							</td>
						</tr>
						<tr>
							<td class="left"><div class="captoin">メールアドレス(確認用)</div><div class="small_caption">半角英数字で入力してください</div></td>
							<td class="right">
								<?php echo $this->Form->text("ReMailAddress", array("placeholder" => "再度返信先メールアドレスを入力してください"));
									echo $this->Form->error("Contact.ReMailAddress");	 ?>
							</td>
						</tr>
						<tr>
							<td class="left"><div class="captoin">お問い合せ件名</div></td>
							<td class="right">
								<?php echo $this->Form->text("Title", array("placeholder" => "お問い合せ件名を入力してください"));
									echo $this->Form->error("Contact.Title");	?>
							</td>
						</tr>
						<tr>
							<td class="left"><div class="captoin">お問い合せ内容</div></td>
							<td class="right">
								<?php echo $this->Form->textarea("Context", array("placeholder" => "お問い合わせの内容を入力してください"));
									echo $this->Form->error("Contact.Contact");	?>
							</td>
						</tr>
					</table>

					<div class="send">
						<?php
							echo $this->Form->submit('確認',array('name' => 'first'));
							echo $this->Form->end();
						?>
					</div>

				</div>
			</div>
		</div>
	<?php }elseif(isset($Contact)){ ?>
		
		<div class="contact_subtitle">お問い合わせ内容は以下の通りでよろしいでしょうか？</div>
			<?php	echo $this->Form->create('Contact');	?>
		<table>
			<tr>
				<td class="left"><div class="captoin">お名前</div><div class="small_caption">全角で入力してください</div></td>
				<td class="right">
					<?php echo $Contact['Name'];
						echo $this->Form->hidden("Contact.Name", array('value' => $Contact['Name']));	?>
				</td>
			</tr>
			<tr>
				<td class="left"><div class="captoin">メールアドレス</div><div class="small_caption">半角英数字で入力してください</div></td>
				<td class="right">
					<?php echo $Contact['MailAddress'];
						echo $this->Form->hidden("Contact.MailAddress", array('value' => $Contact['MailAddress'])); ?>
				</td>
			</tr>
			<tr>
				<td class="left"><div class="captoin">お問い合せ件名</div></td>
				<td class="right">
					<?php echo $Contact['Title'];
						echo $this->Form->hidden("Contact.Title", array('value' => $Contact['Title']));	?>
				</td>
			</tr>
			<tr>
				<td class="left"><div class="captoin">お問い合せ内容</div></td>
				<td class="right">
					<?php echo $Contact['Context'];
						echo $this->Form->hidden("Contact.Context", array('value' => $Contact['Context']));	?>
				</td>
			</tr>
		</table>

		<div class="send">
				<div style="float:right;"><?php
					echo $this->Form->submit('送信', array('name' => 'confirm')); ?></div>			
				<div style="float:right; margin-right: 20px;">
					<?php echo $this->Form->submit('戻る', array('name' => 'back')); ?>
					<?php echo $this->Form->end(); ?>
				</div>
		</div>
		
	<?php }elseif(isset($Confirm)){ ?>
		<div class="contact_subtitle">お問い合わせが完了しました</div>
		<div>
			<h2><a href="/hakoeve/Events/">HOMEへ戻る</a></h2>
		</div>
	<?php } ?>
</div>