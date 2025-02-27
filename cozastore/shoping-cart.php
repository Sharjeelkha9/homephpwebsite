<?php
include("components/header.php");
?>

	<!-- breadcrumb -->
	<div class="container m-t-100	">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Shoping Cart
			</span>
		</div>
	</div>
		

	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<?php
							if(isset($_SESSION['cart'])){
								?>
									<table class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Product</th>
									<th class="column-2"></th>
									<th class="column-3">Price</th>
									<th class="column-4">Quantity</th>
									<th class="column-5">Total</th>
									<th class="column-5">Remove</th>

								</tr>
<?php
foreach($_SESSION['cart'] as $key => $values){
	$total  = $values['proquantity']*$values['proprice'];
	?>
		<tr class="table_row">
									<td class="column-1">
										<div class="how-itemcart1">
											<img src="<?php echo $proaddress.$values['proimage']?>" alt="IMG">
										</div>
									</td>
									<td class="column-2"><?php echo $values['proname']?></td>
									<td class="column-3">PKR <?php echo $values['proprice']?></td>
									<td class="column-4">
										<div class="text-center">
											<?php echo $values['proquantity']?>
										</div>
									</td>
									<td class="column-5">PKR <?php echo $total?></td>
									<td class="column-5"><a href="?remove=<?php echo $values['proid']?>" class="btn btn-danger">Remove</a></td>

								</tr>
	<?php
}
?>
							

								
							</table>
								<?php
							}
							?>
						
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Cart Totals
						</h4>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2">
								PKR: <?php echo $subTotal?>
								</span>
							</div>
						</div>

						<?php
						if(isset($_SESSION['username'])){
							?>
							<a href="order.php" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Proceed to Checkout</a>
							<?php
						}else{
							?>
							<a href="login.php" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Proceed to Checkout</a>
							<?php
						}
						?>
						
					</div>
				</div>
			</div>
		</div>
	</form>
		
	
		

	<?php
include("components/footer.php");
?>