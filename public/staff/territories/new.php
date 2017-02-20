<?php
require_once('../../../private/initialize.php');

$errors = array();
$territory = array(
  'name' => '',
  'state_id' => '',
  'position' => ''
);

if(is_post_request()) {

  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $territory['name'] = h(db_escape($db, $_POST['name'])); }
  if(isset($_POST['state_id'])) { $territory['state_id'] = h(db_escape($db, $_POST['state_id'])); }
  if(isset($_POST['position'])) { $territory['position'] = h(db_escape($db, $_POST['position'])); }

  $result = insert_territory($territory);
  if($result === true) {
    $new_id = db_insert_id($db);
    redirect_to('show.php?id=' . $new_id);
  } else {
    $errors = $result;
  }
}
?>

<?php
// if(!isset($_GET['id'])) {
//   redirect_to('index.php');
// }
if(isset($_GET['id'])){
	$id = $_GET['id'];
}else{
	$id = $_POST['id'];
}
$territory_result = find_territory_by_id($id);
// No loop, only one result
$back_territory = db_fetch_assoc($territory_result);
$state_id = $back_territory['state_id'];
?>


<?php $page_title = 'Staff: New Territory'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../states/show.php?id=<?php echo $back_territory['id']; ?>">Back to State Details</a><br />

  <h1>New Territory</h1>

  <!-- TODO add form -->
  <?php echo display_errors($errors); ?>

  <form action="new.php" method="post">
    Territory name:<br />
    <input type="text" name="name" value="<?php echo $territory['name']; ?>" /><br />
    <input type="hidden" name="state_id"  value="<?php echo $back_territory['id']; ?>" readonly/><br />
    Position:<br />
    <input type="text" name="position" value="<?php echo $territory['position']; ?>" /><br />
   
   	<input type="hidden" name="id" value="<?php echo $back_territory['id']; ?>" />
    <input type="submit" name="submit" value="Create"  />
  </form>


</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
