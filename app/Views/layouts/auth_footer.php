  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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