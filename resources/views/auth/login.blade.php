<x-layout title="Log in">
  <div class="login-form">
    <div class="login-form__header">
      <x-icons.arrow-right-to-bracket />
      <h1>Log in</h1>
      <p>to <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
    </div>

    <x-form action="{{ route('login') }}">
      <x-input name="email" type="email" label="Email" autocomplete="email" autofocus required data-1p-ignore="{{ false }}" />
      <x-input name="password" type="password" label="Password" required data-1p-ignore="{{ false }}" />
      <x-button>Log in</x-button>
    </x-form>
  </div>

  <style>
    @media (max-width: 600px) {
      html {
        background-color: var(--color-white);
      }
    }

    .login-form {
      background-color: var(--color-white);
      display: grid;
      padding: var(--size-24);

      .login-form__header {
        margin-block-end: var(--size-30);

        .x-icon {
          color: var(--color-primary);

          svg {
            font-size: var(--size-40);
          }
        }

        h1 {
          font-size: var(--size-40);
          letter-spacing: var(--letter-spacing-tight);
          line-height: var(--line-height-tight);
          margin-block-end: var(--size-16);
        }

        p {
          color: var(--color-gray-500);

          a {
            color: var(--color-primary);
          }
        }
      }

      .x-button {
        justify-self: end;
      }

      @media (min-width: 600px) {
        border-radius: var(--size-16);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin-block: auto;
        max-width: 540px;
        width: 100%;
      }

      @media (min-width: 1020px) {
        grid-template-columns: 1fr 1fr;
        max-width: 780px;
        padding: var(--size-32);
      }
    }
  </style>
</x-layout>
