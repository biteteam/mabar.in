
const screenGreatherThan = (screenSize) => {
    const sizeConfigured = {
        "sm": 640,
        "md": 768,
        "lg": 1024,
        "xl": 1280,
        "2xl": 1536
    };

    const size = Object?.keys(sizeConfigured)?.includes(screenSize) ? sizeConfigured[screenSize] : 0
    return (window.innerWidth > size);
}

const navMenu = document.querySelector('#nav-menu-wrapper');
// const navMenuTopInit = navMenu?.getBoundingClientRect()?.top < 80 ? 80 : navMenu?.getBoundingClientRect()?.top
const navMenuTopInit = 80

const navMenuAction = (oldScrollY, scrollY) => {
    const isScrollDown = (oldScrollY < scrollY);
    const isScrollTop = (oldScrollY > scrollY);

    if (screenGreatherThan('md')) {
        if (isScrollDown && scrollY > navMenuTopInit) {
            navMenu.classList.replace("nav-menu-wrapper", "nav-menu-wrapper-on-top")
            navMenu.previousElementSibling.classList.replace("opacity-100", "opacity-0");
            navMenu.querySelector('.profile-toggle').classList.replace("opacity-0", "opacity-100");
            document.querySelector('header .profile-toggle').classList.replace("opacity-100", "opacity-0");
            document.querySelector('header').classList.add("header-on-top");
        } else if (isScrollTop && scrollY < navMenuTopInit) {
            navMenu.classList.replace("nav-menu-wrapper-on-top", "nav-menu-wrapper")
            navMenu.previousElementSibling.classList.replace("opacity-0", "opacity-100");
            navMenu.querySelector('.profile-toggle').classList.replace("opacity-100", "opacity-0");
            document.querySelector('header .profile-toggle').classList.replace("opacity-0", "opacity-100");
            document.querySelector('header').classList.remove("header-on-top");

        }
    } else {
        if (navMenu.classList.contains("nav-menu-wrapper-on-top")) navMenu.classList.replace("nav-menu-wrapper-on-top", "nav-menu-wrapper")
    }
}

window.addEventListener('scroll', function () {
    const oldScrollY = this.oldScrollY
    const scrollY = this.scrollY

    navMenuAction(oldScrollY, scrollY);

    this.oldScrollY = scrollY
})

const profileToggles = document.querySelectorAll('.profile-toggle')
const profileMenu = document.querySelector('.profile-menu');

profileToggles?.forEach(profileToggle => {
    profileToggle.addEventListener('click', () => {
        if (screenGreatherThan("md")) {
            if (profileMenu.classList.contains('opacity-0')) {
                profileMenu.classList.replace('-z-50', 'z-50')
                profileMenu.classList.replace('-translate-y-full', 'translate-y-0')
                profileMenu.classList.replace('opacity-0', 'opacity-100')
            } else {
                profileMenu.classList.replace('translate-y-0', '-translate-y-full')
                profileMenu.classList.replace('opacity-100', 'opacity-0')
                profileMenu.classList.replace('z-50', '-z-50')
            }
        } else {
            window.location.href = "/profile"
        }
    });
})

const inputPasswordShowBtns = document.querySelectorAll('[aria-label="password-show"]')
inputPasswordShowBtns.forEach(passwordShowBtn => {
    passwordShowBtn.addEventListener('click', () => {
        const input = passwordShowBtn.previousElementSibling
        const eye = passwordShowBtn.querySelector('.fa-eye')
        const eyeSlash = passwordShowBtn.querySelector('.fa-eye-slash')

        if (input.type == 'password') {
            eyeSlash.classList.replace('hidden', 'inline')
            eye.classList.replace('inline', 'hidden')
            input.setAttribute('type', 'text')
        } else {
            eye.classList.replace('hidden', 'inline')
            eyeSlash.classList.replace('inline', 'hidden')
            input.setAttribute('type', 'password')

        }
    })
});

window.addEventListener('resize', () => navMenuAction(0, window.scrollY))

if (window.scrollY > 0 && navMenu?.classList?.contains('nav-menu-wrapper')) navMenuAction(window?.oldScrollY ?? 0, window.scrollY)
