<template>
  <LegacyCard>
    <ExceptionList
      v-if="!success"
      :items="[
        {
          icon: NoteIcon,
          description: message,
        },
      ]"
    />
    <DataTable
      v-if="success"
      :headings="tableHeadings"
      :columnContentTypes="columnContentTypes"
      :rows="products"
      :footerContent="`Showing ${products.length} of ${products.length} results`"
    >
    </DataTable>
  </LegacyCard>
</template>

<script setup>
defineProps({
  user: Object,
  products: Object,
  success: Boolean,
  message: String,
});

const tableHeadings = ["SKU", "Title"];
const columnContentTypes = ["string", "text"];
</script>
