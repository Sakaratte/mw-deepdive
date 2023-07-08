<?php
	include_once "connection.php";
	include_once "regex.php";
	echo "Getting query\n";
	$qry = "select rev_id, old_id, content_id, slot_revision_id, rev_timestamp, comment_id from wook.revision r inner join wook.slots s on r.rev_id = s.slot_revision_id inner join wook.content c on c.content_id = s.slot_content_id inner join wook.text t on t.old_id = right(c.content_address, length(c.content_address) - 3) left join revision_comment_temp rct on rct.revcomment_rev = r.rev_id left join comment rc on rc.comment_id = rct.revcomment_comment_id;";
//	$qry = "select old_id from wook.text left join content c on t.old_id = right(c.content_address, length(c.content_address) - 3) where c.content_address is null;";
	echo "Connecting to Database\n";
	$data = $conn->query($qry);
	echo "Begin Cleardown\n";
	foreach ($data as $row) {
		echo "Checking revision " . $row['rev_id'] . "\n";
		if ($row['rev_timestamp'] > 20230304235959) {
			$rtext = "delete from wook.text where old_id = " . $row['old_id'];
			$rcontent = "delete from wook.content where content_id = " . $row['content_id'];
			$rslot = "delete from wook.slots where slot_revision_id = " . $row['slot_revision_id'];
			$rtcomment = "delete from wook.revision_comment_temp where rev_comment_rev = " . $row["rev_id"];
			$rcomment = "delete from wook.comment where comment_id = " . $row["comment_id"];
			$rrev = "delete from wook.revision where rev_id = " . $row['rev_id'];
			echo "Deleting revision " . $row['slot_revision_id'] . "\n";
			$conn->query($rtext);
			echo "Text deleted\n";
			$conn->query($rcontent);
			echo "Content deleted\n";
			$conn->query($rslot);
			echo "Slot deleted\n";
			$conn->query($rrev);
			echo "Revision deleted\n";
			$conn->query($rtcomment);
			echo "Revision Comment Temp Deleted\n";
			$conn->query($rcomment);
			echo "Comment deleted";
		}
	}
	echo "Cleardown complete\n";
?>
