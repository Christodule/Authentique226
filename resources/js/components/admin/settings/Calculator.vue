<template>
  <div id="calculator">
    <calculator-content></calculator-content>
  </div>
</template>

<script>
import CalculatorContent from './../Basic'
export default {
  name: 'calculator',
  components: {
    CalculatorContent
  }
 }
</script>

<style>

.calculator{
  width: 34rem;
  height: 40rem;
  background-color: transparent;
  font-size: 1.6rem;
  -webkit-border-radius: 1rem;
  -moz-border-radius: 1rem;
  -ms-border-radius: 1rem;
  -o-border-radius: 1rem;
  border-radius: 1rem;: 
  -webkit-box-shadow: 1rem 1rem 0.5rem #ccc;
  box-shadow: 1rem 1rem 0.5rem #ccc;
  
}
</style>