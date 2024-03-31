<template>
  <Navbar />
  <!-- <img alt="Vue logo" src="./assets/logo.png"> -->
  <!-- <HelloWorld /> -->
  <Footer />
  <router-view></router-view>
</template>

<script>
// import HelloWorld from './components/HelloWorld.vue'
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue'
export default {
  name: 'App',
  components: {
    // HelloWorld,
    Navbar,
    Footer
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
