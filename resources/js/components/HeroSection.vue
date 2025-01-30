<script>
export default {
  name: 'HomeHero',
  data() {
    return {
      categories: [
        { name: 'BAGS', image: 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=870&auto=format&fit=crop', path: '/bags' },
        { name: 'SHOES', image: 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=880&auto=format&fit=crop', path: '/shoes' },
        { name: 'CLOTHING', image: 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=874&auto=format&fit=crop', path: '/clothing' },
        { name: 'ACCESSORIES', image: 'https://images.unsplash.com/photo-1582142306909-195724d33ffc?q=80&w=870&auto=format&fit=crop', path: '/accessories' },
        { name: 'VINTAGE', image: 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=870&auto=format&fit=crop', path: '/vintage' }
      ],
      currentSlide: 0
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
    // setInterval(this.nextSlide, 5000)
  }
}
</script>

<template>
 <div class="container">
  <section class="bg-light py-4 p-2 mt-5 rounded-3">
    <div class="container p-4">
      <div class="row align-items-center">
        <div class="col-md-12">
          <h2 class="h3 mb-2">Take 10% Off Your First Order</h2>
          <p class="mb-md-0">Use code WELCOMEWIT to save 10% off.</p>
        </div>
        <div class="col-md-4 mt-2">
          <a href="/shop" class="btn btn-dark rounded-0 px-4">
            Save Now →
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Hero Carousel -->
  <div id="heroCarousel" class="carousel slide mt-5 rounded-3" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div 
        class="carousel-item" 
        :class="{ active: currentSlide === 0 }"
        style="background-image: url('https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=2070&auto=format&fit=crop')"
      >
        <div class="carousel-content text-center text-white">
          <h1 class="display-3 fw-normal mb-4">Dive into a World of<br>luxury brands products</h1>
          <p class="lead mb-4">French-made, vegan, and cruelty-free nail polish. Breathable, luxurious formula<br>with natural Sugarcane, Cassava, Cotton, and Corn ingredients.</p>
          <a href="/shop" class="btn btn-light rounded-0 px-4 py-2">
            Shop Now →
          </a>
        </div>
      </div>
    </div>
</div>
<div class="carousel-indicators">
  <button v-for="n in 3" :key="n" 
    :class="{ active: currentSlide === n-1 }"
    @click="setSlide(n-1)"

  ></button>
  </div>

  <!-- Shop by Category -->
  <section class="py-5">
    <div class="container">
      <h2 class="h3 mb-4 fs-1 fw-bold">Shop by category</h2>
      <div class="row g-4">
        <div class="col-6 col-md-4 col-lg" v-for="category in categories" :key="category.name">
          <a :href="category.path" class="category-card">
            <div class="category-image">
              <img :src="category.image" :alt="category.name" class="img-fluid">
            </div>
            <h3 class="category-title">{{ category.name }}</h3>
          </a>
        </div>
      </div>
    </div>
  </section>

</div>
</template>

<style scoped>
/* Promo Section */
.bg-light {
  background-color: #F4F0EC !important;
}

.btn {
  font-size: 0.9rem;
  letter-spacing: 0.5px;
  text-transform: none;
  padding: 0.5rem 1.5rem;
}

/* Carousel */
.carousel {
  height: 600px;
  overflow: hidden;
  background-color: #000;
}

.carousel-item {
  height: 600px;
  background-size: cover;
  background-position: center;
  position: relative;
}

.carousel-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.3);
}

.carousel-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
  padding: 0 15px;
}

.carousel-content h1 {
  font-weight: 400;
  letter-spacing: -0.5px;
}

.carousel-content .lead {
  font-size: 1.1rem;
  font-weight: 400;
  line-height: 1.6;
  opacity: 0.9;
}

.carousel-indicators {
  margin-bottom: 2rem;
}

.carousel-indicators button {
  width: 10px;
  height: 4px;
  border-radius: 10px;
  background-color: white;
  border: 1px solid black;
  margin: 0 4px;
}

.carousel-indicators button.active {
  background-color: black;
  width: 108px;
  height: 4px;
  border-radius: 10px;
}

/* Category Cards */
.category-card {
  display: block;
  text-decoration: none;
  color: inherit;
  transition: transform 0.3s;
}

.category-card:hover {
  transform: translateY(-5px);
}

.category-image {
  position: relative;
  padding-bottom: 100%;
  overflow: hidden;
  border-radius: 4px;
}

.category-image img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.category-title {
  margin-top: 1rem;
  text-align: center;
  font-size: 0.9rem;
  font-weight: 500;
  letter-spacing: 1px;
}

@media (max-width: 768px) {
  .carousel {
    height: 500px;
  }
  
  .carousel-item {
    height: 500px;
  }
  
  .carousel-content h1 {
    font-size: 2.5rem;
  }
  
  .carousel-content .lead {
    font-size: 1rem;
  }
}
</style>