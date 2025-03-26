/**
 * GoZupees Affiliate Product Display Bookmark functionality
 */
(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        // Get stored bookmarks from localStorage
        const storedBookmarks = localStorage.getItem('affiliate_product_bookmarks');
        let bookmarks = storedBookmarks ? JSON.parse(storedBookmarks) : [];

        // Apply active class to bookmarked products
        bookmarks.forEach(id => {
            $(`.bookmark-icon[data-product-id="${id}"]`).addClass('active');
        });

        // Bookmark icon click handler
        $('.bookmark-icon').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $this = $(this);
            const productId = $this.data('product-id');
            
            // Toggle active class
            $this.toggleClass('active');
            
            // Update bookmarks array
            if ($this.hasClass('active')) {
                // Add to bookmarks if not already there
                if (!bookmarks.includes(productId)) {
                    bookmarks.push(productId);
                }
            } else {
                // Remove from bookmarks
                bookmarks = bookmarks.filter(id => id !== productId);
            }
            
            // Save to localStorage
            localStorage.setItem('affiliate_product_bookmarks', JSON.stringify(bookmarks));
            
            // Prevent link click
            return false;
        });
    });

})(jQuery);