<?php echo $this->Html->css('about_add'); ?>
<div class="about_add">
	<div class="about_add_top"> 
		<font color="#000">HakoEve（はこイブ）へイベントの登録をするには</font>
	</div>

	<?php if((!isset($Contact) && !isset($Confirm))|| isset($Back)){?>
		<div class ="about_add_detail_1">
			<div class ="about_add_detail_title_1">
				<div ><font color="#000">このページからイベント登録の申請を行うことができます。<br/>掲載する情報をお伝えください。</font></div>
			</div> 
			<br/>
		
			<div class="about_add_detail_1_text_4">
				<div><font style="margin-bottom:1px" , color="#000">
				イベントの情報を入力してください（政治活動・宗教活動に関連するものは掲載できません）。 </font></div>
		
			</div>
			<br/>	
		


			<?php
				echo $this->Form->create('Contact',array('type'=>'file'));
			?>

			<table>
				<tr>
					<td class="left"><div class="captoin">代表者名</div><div class="small_caption">全角で入力してください</div></td>
					<td class="right">
						<?php 
							if(!isset($Back)) echo $this->Form->text("Name", array("placeholder" => "お名前を入力してください"));
							else echo $this->Form->text("Name", array("value" => $Back['Name']));
							echo $this->Form->error("Contact.Name");
					?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">代表者メールアドレス</div><div class="small_caption">半角英数字で入力してください</div></td>
					<td class="right">
						<?php
							if(!isset($Back)) echo $this->Form->text("MailAddress", array("placeholder" => "返信先メールアドレスを入力してください。"));
							else echo $this->Form->text("MailAddress", array("value" => $Back['MailAddress']));
							echo $this->Form->error("Contact.MailAddress");
						?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">メールアドレス(確認用)</div><div class="small_caption">半角英数字で入力してください</div></td>
					<td class="right">
						<?php
							if(!isset($Back)) echo $this->Form->text("ReMailAddress", array("placeholder" => "再度返信先メールアドレスを入力してください。"));
							else echo $this->Form->text("ReMailAddress", array("value" => $Back['ReMailAddress']));
							echo $this->Form->error("Contact.ReMailAddress");
					?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">イベント名</div></td>
					<td class="right">
					<?php
						if(!isset($Back)) echo $this->Form->text("EventTitle", array("placeholder" => "イベント名を入力してください。"));
						else echo $this->Form->text("EventTitle", array("value" => $Back['EventTitle']));
						echo $this->Form->error("Contact.EventTitle");
					?>
						<div>例：第10回 NPOまつり</div>
					</td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">開催日時</div></td>
					<td class="right">
					<?php
						if(!isset($Back)) echo $this->Form->textarea("DeteTime", array("placeholder" => "開催日および開催時間を入力してください。\n開催日時が複数日にわたる場合は、それがわかるように入力してください。", "class" => "datetime_in"));
						else echo $this->Form->textarea("DeteTime", array("value" => $Back['DeteTime'] , "class" => "datetime_in"));
						echo $this->Form->error("Contact.DeteTime");
					?>
						<div>例：2014年9月6日 土曜日 10:00～15:00</div>
						<div>　　2014年9月7日 日曜日 10:00～15:00</div>
					</td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">開催場所</div></td>
					<td class="right">
						<?php
							if(!isset($Back)) echo $this->Form->textarea("Venue", array("placeholder" => "開催場所とその住所を入力してください。", "class" => "venue_in"));
							else echo $this->Form->textarea("Venue", array("value" => $Back['Venue'], "class" => "venue_in"));
							echo $this->Form->error("Contact.Venue");
						?>
						<div>例：まちづくりセンター</div>
						<div>　　北海道函館市末広町 4-19</div>
					</td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">主催者情報</div></td>
					<td class="right">
						<?php
							if(!isset($Back)) echo $this->Form->textarea("Host", array("placeholder" => "団体名または代表者名、住所、連絡先を入力してください。", "class" => "host_in"));
							else echo $this->Form->textarea("Host", array("value" => $Back['Host'], "class" => "host_in"));
							echo $this->Form->error("Contact.Host");
						?>
						<div>例：まちづくりセンター</div>
						<div>　　北海道函館市末広町 4-19</div>
						<div>　　0138-22-9700</div>
					</td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">イベント詳細</div></td>
					<td class="right">
						<?php
							if(!isset($Back)) echo $this->Form->textarea("Detail", array("placeholder" => "イベントの詳細を入力してください。\nイベントの詳細はできる限り詳しく書いてください。"));
							else echo $this->Form->textarea("Detail", array("value" => $Back['Detail']));
							echo $this->Form->error("Contact.Detail");
						?>
					</td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">備考</div></td>
					<td class="right">
						<?php
							if(!isset($Back)) echo $this->Form->textarea("Remarks", array("placeholder" => ""));
							else{ echo $this->Form->textarea("Remarks", array("value" => $Back['Remarks']));}?>
					</td>
				</tr>
		
				<tr>
					<td class="left" style="width:140px;"><div class="captoin">画像ファイル</div></td>
					<td class="right">
						<div>png，jpeg形式のファイルをこのメールフォームに添付するか、ポスターを直接まちづくりセンターまでお届け下さい。</div>
						<div>最大3枚まで受け付けています。</div>
							<div>
								<div style="float:left; width:55%;">
									<?php echo $this->Form->file("file_0",array('id' => "file_0"));
										echo $this->Form->error('Contact.file_0');
										echo "<br/>"; ?>
										<div id="pre_img_0"><?php if($PrevImg[0] != "") echo "<h1>" . $PrevImg[0] . "が選択されています</h1>";?></div>
								</div>
								<div id="file_0_img" style="float:left; width:45%; height:100px;">
									<?php if($PrevImg[0] != ""){ echo $this->Html->image("../files/".$PrevImg[0], array('style' => array('height:100px')));
										echo $this->Form->hidden('Contact.file_0.prevname', array('value' => $PrevImg[0]));}?>
								</div>
							</div>
							
							<div>
								<div style="float:left; width:55%;">
									<?php echo $this->Form->file("file_1",array('id' => "file_1"));
										echo $this->Form->error('Contact.file_1');
										echo "<br/>"; ?>
									<div id="pre_img_0"><?php if($PrevImg[1] != "") echo "<h1>" . $PrevImg[1] . "が選択されています</h1>";?></div>
								</div>
								<div id="file_1_img" style="float:left; width:45%; height:100px;">
									<?php if($PrevImg[1] != ""){ echo $this->Html->image("../files/".$PrevImg[1], array('style' => array('height:100px')));
										echo $this->Form->hidden('Contact.file_1.prevname', array('value' => $PrevImg[1]));}?>
								</div>
							</div>
							
							<div>
								<div style="float:left; width:55%;">
									<?php echo $this->Form->file("file_2",array('id' => "file_2"));
										echo $this->Form->error('Contact.file_2');?>
										<div id="pre_img_0"><?php if($PrevImg[2] != "") echo "<h1>" . $PrevImg[2] . "が選択されています</h1>";?></div>
								</div>
								<div id="file_2_img" style="float:left; width:45%; height:100px;">
									<?php if($PrevImg[2] != ""){ echo $this->Html->image("../files/".$PrevImg[2], array('style' => array('height:100px')));
										echo $this->Form->hidden('Contact.file_2.prevname', array('value' => $PrevImg[2]));}?>
								</div>
							</div>
					</td>
				</tr>
			</table>

			<div class="send">
				<?php
					echo $this->Form->submit('確認', array('name' => 'first'));
					echo $this->Form->end();
				?>
			</div>
		</div>	
	
	
	<?php } elseif(isset($Contact)){ ?>
			<div class="about_add_detail_title_2">
				<div>申請内容は以下の通りでよろしいでしょうか？</div>
			</div>
			<?php	echo $this->Form->create('Contact',array('type'=>'file'));	?>
			<table>
				<tr>
					<td class="left"><div class="captoin">代表者名</div><div class="small_caption">全角で入力してください</div></td>
					<td class="right">
						<?php echo 	$Contact['Name'];?>
						<?php echo $this->Form->hidden('Contact.Name',array('value' => $Contact['Name'])); ?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">代表者メールアドレス</div><div class="small_caption">半角英数字で入力してください</div></td>
					<td class="right">
						<?php echo $Contact['MailAddress'];?>
						<?php echo $this->Form->hidden('Contact.MailAddress',array('value' => $Contact['MailAddress'])); ?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">イベント名</div></td>
					<td class="right">
						<?php echo $Contact['EventTitle'];?>
						<?php echo $this->Form->hidden('Contact.EventTitle',array('value' => $Contact['EventTitle'])); ?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">開催日時</div></td>
					<td class="right">
						<?php echo $Contact['DeteTime'];?>
						<?php echo $this->Form->hidden('Contact.DeteTime',array('value' => $Contact['DeteTime'])); ?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">開催場所</div></td>
					<td class="right">
						<?php echo $Contact['Venue'];?>
						<?php echo $this->Form->hidden('Contact.Venue',array('value' => $Contact['Venue'])); ?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">主催者情報</div></td>
					<td class="right">
						<?php echo $Contact['Host'];?>
						<?php echo $this->Form->hidden('Contact.Host',array('value' => $Contact['Host'])); ?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">イベント詳細</div></td>
					<td class="right">
						<?php echo $Contact['Detail'];?>
						<?php echo $this->Form->hidden('Contact.Detail',array('value' => $Contact['Detail'])); ?></td>
				</tr>
				<tr>
					<td class="left"><div class="captoin">備考</div></td>
					<td class="right"><?php echo $Contact['Remarks'];?>
						<?php echo $this->Form->hidden('Contact.Remarks',array('value' => $Contact['Remarks'])); ?></td>
				</tr>
		
				<tr>
					<td class="left" style="width:140px;"><div class="captoin">画像ファイル</div></td>
					<td class="right">
						<div>png，jpeg形式のファイルをこのメールフォームに添付するか、ポスターを直接まちづくりセンターまでお届け下さい。</div>
						<div>最大3枚まで受け付けています。</div><?php //echo $Contact['file']['tmp_name']?>
							<?php if($Contact['file_0']['name'] != ""){ ?>
								<?php echo $this->Html->image('../files/' . $Contact['file_0']['name'], array('style' => array('width:15%;','float:left;'))); ?>
							<?php } ?>		
							<?php
								echo $this->Form->hidden('Contact.file_0.name', array('value' => $Contact['file_0']['name']));
								echo $this->Form->hidden('Contact.file_0.type', array('value' => $Contact['file_0']['type']));
								echo $this->Form->hidden('Contact.file_0.tmp_name', array('value' => $Contact['file_0']['tmp_name']));
								echo $this->Form->hidden('Contact.file_0.error', array('value' => $Contact['file_0']['error']));
								echo $this->Form->hidden('Contact.file_0.size', array('value' => $Contact['file_0']['size']));
							?>
							<?php if($Contact['file_1']['name'] != ""){ ?>
								<?php echo $this->Html->image('../files/' . $Contact['file_1']['name'], array('style' => array('width:15%;','float:left;'))); ?>
							<?php } ?>
							<?php
								echo $this->Form->hidden('Contact.file_1.name', array('value' => $Contact['file_1']['name']));
								echo $this->Form->hidden('Contact.file_1.type', array('value' => $Contact['file_1']['type']));
								echo $this->Form->hidden('Contact.file_1.tmp_name', array('value' => $Contact['file_1']['tmp_name']));
								echo $this->Form->hidden('Contact.file_1.error', array('value' => $Contact['file_1']['error']));
								echo $this->Form->hidden('Contact.file_1.size', array('value' => $Contact['file_1']['size']));
							?>							
							<?php if($Contact['file_2']['name'] != ""){ ?>
								<?php echo $this->Html->image('../files/' . $Contact['file_2']['name'], array('style' => array('width:15%;','float:left;'))); ?>
							<?php } ?>
							<?php
								echo $this->Form->hidden('Contact.file_2.name', array('value' => $Contact['file_2']['name']));
								echo $this->Form->hidden('Contact.file_2.type', array('value' => $Contact['file_2']['type']));
								echo $this->Form->hidden('Contact.file_2.tmp_name', array('value' => $Contact['file_2']['tmp_name']));
								echo $this->Form->hidden('Contact.file_2.error', array('value' => $Contact['file_2']['error']));
								echo $this->Form->hidden('Contact.file_2.size', array('value' => $Contact['file_2']['size']));
							?>							
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
	<?php }elseif(isset($Confirm)){?>
	
		<div class="about_add_detail_2">
			<div class="about_add_detail_title_2">
				<div>イベント登録申請は完了です。</div>
			</div>
				<div class="about_add_detail_2_text_1"> 
					<h1><font color="#000">HakoEve掲載後にご報告の連絡をいたします。</font></h1>
				</div>
				
				<div>
					<h2><a href="/hakoeve/Events/">HOMEへ戻る</a></h2>
				</div>
		</div>

	<?php } ?>
		
</div>

<script>
var obj0 = document.getElementById("file_0");
var obj1 = document.getElementById("file_1");
var obj2 = document.getElementById("file_2");
obj0.addEventListener("change", function(evt){
  var file = evt.target.files;
  var reader = new FileReader();
  
  //dataURL形式でファイルを読み込む
  reader.readAsDataURL(file[0]);
  
  //ファイルの読込が終了した時の処理
  reader.onload = function(){
    var dataUrl = reader.result;
    //読み込んだ画像とdataURLを書き出す
    document.getElementById("file_0_img").innerHTML = "<img src='" + dataUrl + "'style='height:100px'>";
    document.getElementById("pre_img_0").innerHTML = "";
  }
},false);
obj1.addEventListener("change", function(evt){
  var file = evt.target.files;
  var reader = new FileReader();
  
  //dataURL形式でファイルを読み込む
  reader.readAsDataURL(file[0]);
  
  //ファイルの読込が終了した時の処理
  reader.onload = function(){
    var dataUrl = reader.result;
    //読み込んだ画像とdataURLを書き出す
    document.getElementById("file_1_img").innerHTML = "<img src='" + dataUrl + "'style='height:100px'>";
    document.getElementById("pre_img_1").innerHTML = "";
  }
},false);
obj2.addEventListener("change", function(evt){
  var file = evt.target.files;
  var reader = new FileReader();
  
  //dataURL形式でファイルを読み込む
  reader.readAsDataURL(file[0]);
  
  //ファイルの読込が終了した時の処理
  reader.onload = function(){
    var dataUrl = reader.result;
    //読み込んだ画像とdataURLを書き出す
    document.getElementById("file_2_img").innerHTML = "<img src='" + dataUrl + "'style='height:100px'>";
    document.getElementById("pre_img_2").innerHTML = "";
  }
},false);
</script>