<template>
  <LegacyCard>
    <DataTable
      :headings="tableHeadings"
      :columnContentTypes="columnContentTypes"
      :rows="products"
      :sortable="sortable"
      :footerContent="`Showing ${products.length} of ${products.length} results`"
      :truncate="false"
      defaultSortDirection="descending"
    >
    </DataTable>
  </LegacyCard>
</template>

<script setup>
defineProps({ user: Object, products: Object });

const tableHeadings = ["ID", "Title", "Vendor", "Category", "Price", "Status"];
const columnContentTypes = [
  "string",
  "string",
  "string",
  "string",
  "string",
  "string",
];
const sortable = [true, true, true, true, true, true];
</script>
