						</div><!-- .content -->

						<?php hinagata_widget( 'main_after_content', 'content' ); ?>

					</div><!-- .container -->

					<?php hinagata_widget( 'main_after_container', 'container' );?>

				</div><!-- .wrapper -->

			</main>

			<footer>

				<div class="wrapper">

					<?php hinagata_widget( 'footer_before_container', 'container' );?>

					<div class="container">

						<?php hinagata_widget( 'footer_before_content', 'content' ); ?>

						<div class="content">

							<div id="colophon">
								<?php hinagata_colophon(); ?>
							</div>

						</div><!-- .content -->

						<?php hinagata_widget( 'footer_after_content', 'content' ); ?>

					</div><!-- .container -->

					<?php hinagata_widget( 'footer_after_container', 'container' ); ?>

				</div><!-- .wrapper -->

			</footer>

		</div><!-- #page -->

		<?php wp_footer(); ?>

	</body>

</html>
