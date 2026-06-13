            </main>

            {{-- Toast Notification --}}
            <div
                id="localhost-toast"
                aria-live="polite"
                class="fixed left-1/2 -translate-x-1/2 -top-32 z-[9999] transition-all duration-300"
            >
                <div
                    id="localhost-toast-box"
                    class="bg-blue-900 text-white px-4 py-3 rounded-lg shadow-lg text-sm"
                >
                    <span id="localhost-toast-msg"></span>
                </div>
            </div>

            {{-- Footer --}}
            <footer class="bg-white border-t py-4 text-center text-gray-600 text-sm">
                &copy; {{ date('Y') }} Puskesmas
            </footer>

        </div>
    </div>

    {{-- Layout JS --}}
    <script src="{{ asset('style/js/layout.js') }}"></script>

    {{-- Toast JS --}}
    <script src="{{ asset('style/js/spesialis-toast.js') }}"></script>

</body>
</html>