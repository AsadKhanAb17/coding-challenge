<script>
export default {
  name: 'Footer',
  data() {
    return {
      buyLinks: [
        { name: 'Where is my order?', path: '/track-order' },
        { name: 'How do we authenticate?', path: '/authentication' },
        { name: 'Returns policy', path: '/returns' }
      ],
      sellLinks: [
        { name: 'How to list?', path: '/how-to-list' },
        { name: 'Expert Selling Advice', path: '/selling-advice' },
        { name: 'Sell on Wear It', path: '/sell' }
      ],
      helpLinks: [
        { name: 'Help Center', path: '/help' },
        { name: 'Contact us', path: '/contact' },
        { name: 'FAQs', path: '/faqs' }
      ],
      socialLinks: [
        { name: 'Instagram', icon: 'Instagram.png', url: '#' },
        { name: 'Facebook', icon: 'facebook.png', url: '#' },
        { name: 'WhatsApp', icon: 'WhatsApp.png', url: '#' }
      ]
    }
  }
}
</script>

<template>
  <footer class="bg-black text-white py-5">
    <div class="container">
      <div class="row mb-5">
        <!-- Buy Section -->
        <div class="col-6 col-md-3 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">Buy</h5>
          <ul class="list-unstyled">
            <li v-for="link in buyLinks" :key="link.name" class="mb-2">
              <a :href="link.path" class="text-muted text-decoration-none hover-white">{{ link.name }}</a>
            </li>
          </ul>
        </div>

        <!-- Sell Section -->
        <div class="col-6 col-md-3 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">Sell</h5>
          <ul class="list-unstyled">
            <li v-for="link in sellLinks" :key="link.name" class="mb-2">
              <a :href="link.path" class="text-muted text-decoration-none hover-white">{{ link.name }}</a>
            </li>
          </ul>
        </div>

        <!-- Logo Section -->
        <div class=" col-12 text-center text-md-start col-md-3 mb-4 ">
          <img src="/logodark.png" alt="WEAR IT" class="mb-3" width="150px">
        </div>

        <!-- Help Section -->
        <div class="col-md-3">
          <div class="d-flex justify-content-between">
            <div>
              <h5 class="text-uppercase mb-4">Help</h5>
              <ul class="list-unstyled">
                <li v-for="link in helpLinks" :key="link.name" class="mb-2">
                  <a :href="link.path" class="text-muted text-decoration-none hover-white">{{ link.name }}</a>
                </li>
              </ul>
            </div>
            <div>
              <h5 class="text-uppercase mb-4">Social Media</h5>
              <div class="d-flex gap-3">
                <a v-for="social in socialLinks" 
                   :key="social.name"
                   :href="social.url"
                   class="text-white text-decoration-none"
                   :title="social.name">
                   <img :src="social.icon" 
                     alt="Download on the App Store" 
                     height="40">
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Disclaimer -->
      <div class="border-top border-secondary pt-4">
        <div class="row align-items-center">
          <div class="col-md-8 mb-3 mb-md-0">
            <p class="text-muted small mb-0">
              Wear It has no association or affiliation with the brands whose items are offered for sale on its website/app.
            </p>
          </div>
          <div class="col-md-4">
            <div class="d-flex justify-content-md-end gap-3">
              <a href="#" class="app-store-badge">
                <img src="https://developer.apple.com/app-store/marketing/guidelines/images/badge-download-on-the-app-store.svg" 
                     alt="Download on the App Store" 
                     height="40">
              </a>
              <a href="#" class="play-store-badge">
                <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" 
                     alt="Get it on Google Play" 
                     height="40">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.hover-white:hover {
  color: white !important;
  transition: color 0.2s ease;
}

/* Fix Google Play badge height to match App Store */
.play-store-badge img {
  margin-top: -10px;
  margin-bottom: -10px;
}
</style>