<x-layout>
  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>faq layanan informasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- aos untuk scroll animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        AOS.init({ duration: 500, once: true });
      });
    </script>
  </head>
  <body class="bg-gray-50 text-black">
    <!-- section faq -->
    <section class="max-w-6xl mx-auto my-12 p-8 bg-white shadow-lg rounded-lg" data-aos="fade-up">
      <h2 class="text-3xl font-bold mb-6 text-center">faq - layanan informasi</h2>
      <p class="mb-8 text-center">berikut adalah beberapa pertanyaan yang sering diajukan tentang layanan kami.</p>

      <div class="space-y-6">
        <details class="border-b pb-4 group" data-aos="fade-up">
          <summary class="cursor-pointer font-semibold text-lg flex justify-between items-center">
            bagaimana cara berhenti berlangganan?
            <i class="fa-solid fa-chevron-down transition-transform duration-300 ease-in-out group-open:rotate-180"></i>
          </summary>
          <div class="mt-3 opacity-0 group-open:opacity-100 transition-opacity duration-300 ease-in-out">
            <p>anda dapat berhenti berlangganan dengan mengirimkan sms stop ke 12345 atau melalui aplikasi kami di pengaturan akun.</p>
          </div>
        </details>

        <details class="border-b pb-4 group" data-aos="fade-up">
          <summary class="cursor-pointer font-semibold text-lg flex justify-between items-center">
            berapa panjang maksimal pesan?
            <i class="fa-solid fa-chevron-down transition-transform duration-300 ease-in-out group-open:rotate-180"></i>
          </summary>
          <div class="mt-3 opacity-0 group-open:opacity-100 transition-opacity duration-300 ease-in-out">
            <p>panjang maksimal pesan untuk sms adalah 160 karakter. jika lebih, akan dikirim sebagai beberapa pesan.</p>
          </div>
        </details>

        <details class="border-b pb-4 group" data-aos="fade-up">
          <summary class="cursor-pointer font-semibold text-lg flex justify-between items-center">
            apakah bisa mengirim gambar atau video?
            <i class="fa-solid fa-chevron-down transition-transform duration-300 ease-in-out group-open:rotate-180"></i>
          </summary>
          <div class="mt-3 opacity-0 group-open:opacity-100 transition-opacity duration-300 ease-in-out">
            <p>ya, layanan kami mendukung mms sehingga lo bisa mengirim gambar dan video.</p>
          </div>
        </details>

        <details class="border-b pb-4 group" data-aos="fade-up">
          <summary class="cursor-pointer font-semibold text-lg flex justify-between items-center">
            bagaimana cara mendapatkan bantuan lebih lanjut?
            <i class="fa-solid fa-chevron-down transition-transform duration-300 ease-in-out group-open:rotate-180"></i>
          </summary>
          <div class="mt-3 opacity-0 group-open:opacity-100 transition-opacity duration-300 ease-in-out">
            <p>lo bisa hubungi layanan pelanggan kami 24/7 lewat email support@layananinfo.com atau telepon di 0800-123-456.</p>
          </div>
        </details>
      </div>
    </section>

    <!-- section kategori bantuan -->
    <section class="max-w-6xl mx-auto my-12 p-8 bg-white shadow-lg rounded-lg" data-aos="fade-up">
      <h3 class="text-2xl font-bold mb-6 text-center">kategori bantuan</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
        <div class="flex items-center p-6 border rounded-lg shadow-md bg-gray-50">
          <i class="fa-solid fa-cogs text-2xl mr-4"></i>
          <div>
            <h4 class="text-lg font-semibold">getting started</h4>
            <p>mulai dengan cepat dengan panduan instalasi.</p>
          </div>
        </div>
        <div class="flex items-center p-6 border rounded-lg shadow-md bg-gray-50">
          <i class="fa-solid fa-user text-2xl mr-4"></i>
          <div>
            <h4 class="text-lg font-semibold">user account</h4>
            <p>panduan pengelolaan akun pengguna.</p>
          </div>
        </div>
        <div class="flex items-center p-6 border rounded-lg shadow-md bg-gray-50">
          <i class="fa-solid fa-chart-line text-2xl mr-4"></i>
          <div>
            <h4 class="text-lg font-semibold">product features</h4>
            <p>pelajari fitur-fitur utama layanan kami.</p>
          </div>
        </div>
        <div class="flex items-center p-6 border rounded-lg shadow-md bg-gray-50">
          <i class="fa-solid fa-paint-brush text-2xl mr-4"></i>
          <div>
            <h4 class="text-lg font-semibold">customization options</h4>
            <p>sesuaikan tampilan sesuai keinginan.</p>
          </div>
        </div>
        <div class="flex items-center p-6 border rounded-lg shadow-md bg-gray-50">
          <i class="fa-solid fa-credit-card text-2xl mr-4"></i>
          <div>
            <h4 class="text-lg font-semibold">payment gateways</h4>
            <p>integrasi dengan berbagai metode pembayaran.</p>
          </div>
        </div>
        <div class="flex items-center p-6 border rounded-lg shadow-md bg-gray-50">
          <i class="fa-solid fa-lock text-2xl mr-4"></i>
          <div>
            <h4 class="text-lg font-semibold">security options</h4>
            <p>keamanan terbaik untuk layanan anda.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- section ajukan pertanyaan -->
    <section class="text-center bg-gray-100 p-12" data-aos="fade-up">
      <h3 class="text-2xl font-bold mb-4">ajukan pertanyaan</h3>
      <p class="mb-6">masukkan email lo dan pertanyaan yang ingin diajukan.</p>
      <div class="max-w-md mx-auto flex flex-col gap-4">
        <input
          type="email"
          placeholder="email lo"
          class="flex-1 px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-black"
        />
        <textarea
          placeholder="tulis pertanyaan lo..."
          class="flex-1 px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-black"
        ></textarea>
        <button class="bg-black text-white px-6 py-3 rounded-lg shadow-md hover:bg-gray-800">
          kirim pertanyaan
        </button>
      </div>
    </section>
  </body>
  </html>
</x-layout>
