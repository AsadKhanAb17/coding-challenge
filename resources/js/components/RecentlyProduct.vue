<script>
export default {
  name: 'RecentlyProduct',
  data() {
    return {
      categories: [
        { name: 'BAGS', image: 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=870&auto=format&fit=crop', path: '/bags' },
        { name: 'SHOES', image: 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=880&auto=format&fit=crop', path: '/shoes' },
        { name: 'CLOTHING', image: 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=874&auto=format&fit=crop', path: '/clothing' },
        { name: 'ACCESSORIES', image: 'https://images.unsplash.com/photo-1582142306909-195724d33ffc?q=80&w=870&auto=format&fit=crop', path: '/accessories' },
        { name: 'VINTAGE', image: 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=870&auto=format&fit=crop', path: '/vintage' }
      ],
      currentSlide: 0,
      recentlyViewed: [
        {
          brand: 'CELINE',
          name: 'Clasp leather handbag',
          price: 1018,
          originalPrice: 1071,
          image: 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=870&auto=format&fit=crop',
          location: 'Qatar'
        },
        {
          brand: 'GUCCI',
          name: 'GG Buckle leather belt',
          price: 1018,
          originalPrice: 1071,
          image: 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=880&auto=format&fit=crop',
          location: 'Saudi Arabia'
        },
        {
          brand: 'DIOR',
          name: 'Lady Dior Cloth handbag',
          price: 1018,
          originalPrice: 1071,
          image: 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=870&auto=format&fit=crop',
          location: 'United Kingdom'
        },
        {
          brand: 'KHAITE',
          name: 'Cashmere Jumper',
          price: 1018,
          originalPrice: 1071,
          image: 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=874&auto=format&fit=crop',
          location: 'United State'
        },
        {
          brand: 'DOEN',
          name: 'Blouse',
          price: 1018,
          originalPrice: 1071,
          image: 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=874&auto=format&fit=crop',
          location: 'United Arab Emirates'
        }
      ],
      features: [
        {
          title: 'FULLY AUTHENTICATED',
          description: 'Fully authenticated marketplace ensures secure and trusted.',
          icon: '/cross.png'
        },
        {
          title: 'FLEXIBLE PAYMENT PLANS',
          description: 'Flexible payment plans offer convenient, tailored options.',
          icon: '/payment.png'
        },
        {
          title: 'WORLDWIDE SHIPPING',
          description: 'Worldwide shipping ensures global delivery convenience.',
          icon: '/world.png'
        },
        {
          title: 'COMPETITIVE PRICING',
          description: 'Competitive pricing guarantees great value for every purchase.',
          icon: '/pricing.png'
        },
        {
          title: 'SECURE TRANSACTIONS',
          description: 'Secure transactions ensure safe and reliable purchases.',
          icon: '/lock.png'
        }
      ]
    }
  },
  methods: {
    nextSlide() {
      this.currentSlide = (this.currentSlide + 1) % 3
    },
    prevSlide() {
      this.currentSlide = (this.currentSlide - 1 + 3) % 3
    },
    setSlide(index) {
      this.currentSlide = index
    }
  },
  mounted() {
    setInterval(this.nextSlide, 5000)
  }
}
</script>

<template>
<div>
  <section class="py-5 bg">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 fs-1 fw-bold" >Recently viewed</h2>
        <div>
          <button class="btn btn-outline-dark rounded-circle me-2" style="width: 40px; height: 40px;">←</button>
          <button class="btn btn-outline-dark rounded-circle" style="width: 40px; height: 40px;">→</button>
        </div>
      </div>
      
      <div class="row g-4">
        <div class="col" v-for="item in recentlyViewed" :key="item.name">
          <div class="product-card">
            <div class="verified-seller mb-2">
              <span class="badge bg-success-light text-success">
                <i class="bi bi-check-circle-fill me-1"></i>
                Verified Seller
              </span>
            </div>
            <div class="product-image mb-3">
              <img :src="item.image" :alt="item.name" class="img-fluid">
            
            </div>
            <div class="product-info">
              <h3 class="brand mb-1">{{ item.brand }}</h3>
              <p class="name mb-2">{{ item.name }}</p>
              <div class="price-row mb-2">
                <span class="current-price">${{ item.price }}</span>
                <span class="original-price">${{ item.originalPrice }}</span>
              </div>
              <div class="location mb-3">
                <i class="bi bi-geo-alt me-1"></i>
                {{ item.location }}
              </div>
              <button class="btn btn-dark w-100">ADD TO CART</button>
            </div>
          </div>
        </div>
      </div>
      
      <div class="text-center mt-4">
        <button class="btn btn-outline-dark px-4">View all</button>
      </div>
    </div>
  </section>

  <!-- What We Offer Section -->
  <section class="py-5 bg-white">
    <div class="container">
      <h2 class="h3 mb-5 fs-1 fw-bold">What we offer</h2>
      
      <div class="row g-4">
        <div class="col" v-for="feature in features" :key="feature.title">
          <div class="text-center">
            <div class="feature-icon mb-3">
              <img :src="feature.icon" 
                     alt="Download on the App Store" 
                     height="40">
            </div>
            <h3 class="h5 mb-2 fs-5 fw-bold">{{ feature.title }}</h3>
            <p class="text-muted small">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
</template>

<style scoped>
/* Previous styles remain unchanged */
.bg{
  background-color: #F5F5F5;
}
/* Recently Viewed Section */
.product-card {
  position: relative;
  padding: 1rem;
  border-radius: 4px;
  transition: all 0.3s ease;
}


.verified-seller .badge {
  font-weight: normal;
  padding: 0.5rem 0.75rem;
}

.bg-success-light {
  background-color: rgba(25, 135, 84, 0.1);
}

.product-image {
  position: relative;
  padding-bottom: 100%;
  overflow: hidden;
}

.product-image img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;

}


.brand {
  font-size: 0.9rem;
  font-weight: 600;
}

.name {
  font-size: 0.85rem;
  color: #666;
}

.price-row {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.current-price {
  font-weight: 600;
}

.original-price {
  text-decoration: line-through;
  color: #999;
  font-size: 0.85rem;
}

.location {
  font-size: 0.85rem;
  color: #666;
}

/* What We Offer Section */
.icon-circle {
  width: 60px;
  height: 60px;
  background-color: #e9ecef;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: #198754;
  margin-bottom: 1rem;
}

.feature-icon {
  margin-bottom: 1.5rem;
}

/* Responsive Styles */
@media (max-width: 768px) {
  .row {
    flex-wrap: nowrap;
    overflow-x: auto;
    padding-bottom: 1rem;
  }
  
  .col {
    min-width: 280px;
  }
}
</style>