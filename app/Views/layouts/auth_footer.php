  </div>
  </div>
  <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
  <script>
      $(function() {
          // Toggle password visibility
          $('.toggle-password').on('click', function() {
              let input = $(this).closest('.input-group').find('input');
              let type = input.attr('type') === 'password' ? 'text' : 'password';
              input.attr('type', type);
              $(this).toggleClass('text-primary');
          });
      });
  </script>
  </body>

  </html>