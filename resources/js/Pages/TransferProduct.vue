<template>
  {{ message }}
  <ExceptionList
    v-if="!success"
    :items="[
      {
        icon: NoteIcon,
        description: message,
      },
    ]"
  />
  <form @submit.prevent="submit">
    <FormLayout>
      <TextField v-model="form.shopify_product_id" label="Shopify Product Id" />
      <Button :submit="true" :disabled="form.processing">Submit</Button>
    </FormLayout>
  </form>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";

defineProps({
  success: Boolean,
  message: String,
});

const page = usePage();

const form = useForm({
  _token: page.props.csrf_token,
  shopify_product_id: null,
});

function submit() {
  form.post("transfer-product", form);
}
</script>
