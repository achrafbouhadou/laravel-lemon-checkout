<template>
    <div class="bg-gray-50 flex justify-center py-10">
        <div class="bg-white w-full max-w-5xl shadow-lg rounded-lg p-10 flex">
            <!-- Left Section - Shipping and Payment Details -->
            <div class="w-2/3 pr-8">
                <h2 class="text-2xl font-semibold mb-6">Checkout</h2>
                <div class="mb-10">
                    <h3 class="text-lg font-medium mb-3">Payment Details</h3>
                    <form @submit.prevent="handleSubmit">
                        <InputField
                            id="name"
                            label="Name"
                            placeholder="ex: John Doe"
                            v-model="form.name"
                            
                            :error="form.errors.name"
                        />
                        <InputField
                            id="email"
                            label="Email"
                            placeholder="ex: Z5rJt@example.com"
                            v-model="form.email"
                            
                            :error="form.errors.email"

                        />
                        <InputField
                            id="whatsapp"
                            label="WhatsApp Number"
                            placeholder="ex: +1 123 456 7890"
                            v-model="form.whatsapp"
                            :iconSrc=whatsappIcon
                            :error="form.errors.whatsapp"

                        />
                        
                        <PaymentMethodSelector 
                            :methods="paymentMethods" 
                            v-model="form.payment_method" 

                            :error="form.errors.payment_method"
                        />

                        <button 
                            type="submit" 
                            class="bg-teal-500 hover:bg-teal-600 text-white font-medium py-3 px-5 rounded-md w-full transition-colors"
                        >
                            Purchase {{ total }} MAD
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Section - Order Summary -->
            <div class="w-1/3">
                <OrderSummary :items="orderItems" :subtotal="subtotal"  :total="total" :discount="discount" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import stripeLogo from '@assets/images/stripeLogo.png';
import paypalLogo from '@assets/images/Paypal_logo.png';
import lemonSqueezyLogo from '@assets/images/lemon_squeezy_logo.jpeg';
import whatsappIcon from '@assets/images/whatsapp_icon.png'; 
import OrderSummary from '@/Components/OrderSummary.vue';
import InputField from '@/Components/InputField.vue';
import PaymentMethodSelector from '@/Components/PaymentMethodSelector.vue';
import { useForm} from '@inertiajs/vue3';
import { useToast } from "vue-toastification";

const toast = useToast();

const props = defineProps({
    product : Object
});


const form = useForm({
    name: '',
    email: '',
    whatsapp: '',
    payment_method: '',
    total: props.product.price,
    product_id: props.product.id
});



const paymentMethods = ref([
    { id: 'stripe', name: 'Stripe', image: stripeLogo },
    { id: 'paypal', name: 'PayPal', image: paypalLogo },
    { id: 'lemonsqueezy', name: 'LemonSqueezy', image: lemonSqueezyLogo }
]);

const orderItems = ref([
    props.product
]);

const subtotal = ref(props.product.price); // assume that we could just purchase one product (todo)
const discount = ref(0); // assume discount is 0 (todo)
const total = ref(subtotal.value);

const selectPaymentMethod = (methodId) => {
    form.payment_method = methodId;
};

const handleSubmit = () => {
    form.post('/process', {
        onSuccess: () => {
            form.reset();
            toast.success("Order processed successfully!");
        },
        onError: () => {
            if (form.errors.message){
                toast.error(form.errors.message);
            }
        }
})
};
</script>

<style scoped>
</style>
