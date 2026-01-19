<template>
  <div class="donation-card">
    💳 Donation #{{ donationId }}
  </div>
</template>

<script setup>
defineProps({
  donationId: String,
});
</script>
