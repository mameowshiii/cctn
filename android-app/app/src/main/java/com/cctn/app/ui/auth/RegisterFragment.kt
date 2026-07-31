package com.cctn.app.ui.auth

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.fragment.app.viewModels
import androidx.navigation.fragment.findNavController
import com.cctn.app.R
import com.cctn.app.data.model.RegisterRequest
import com.cctn.app.databinding.FragmentRegisterBinding
import com.cctn.app.util.Result
import dagger.hilt.android.AndroidEntryPoint

@AndroidEntryPoint
class RegisterFragment : Fragment() {

    private var _binding: FragmentRegisterBinding? = null
    private val binding get() = _binding!!
    private val viewModel: AuthViewModel by viewModels()

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View {
        _binding = FragmentRegisterBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.btnRegister.setOnClickListener {
            val firstname  = binding.etFirstname.text.toString().trim()
            val lastname   = binding.etLastname.text.toString().trim()
            val email      = binding.etEmail.text.toString().trim()
            val username   = binding.etUsername.text.toString().trim()
            val password   = binding.etPassword.text.toString()
            val confirm    = binding.etConfirmPassword.text.toString()
            val contactNo  = binding.etContactNo.text.toString().trim()
            val barangay   = binding.etBarangay.text.toString().trim()
            val municipal  = binding.etMunicipality.text.toString().trim()
            val province   = binding.etProvince.text.toString().trim()

            if (firstname.isEmpty() || lastname.isEmpty() || email.isEmpty() ||
                username.isEmpty() || password.isEmpty() || contactNo.isEmpty() ||
                barangay.isEmpty() || municipal.isEmpty() || province.isEmpty()) {
                Toast.makeText(requireContext(), "Please fill in all required fields.", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }
            if (password != confirm) {
                binding.etConfirmPassword.error = "Passwords do not match"
                return@setOnClickListener
            }

            viewModel.register(
                RegisterRequest(
                    firstname = firstname,
                    lastname  = lastname,
                    email     = email,
                    username  = username,
                    password  = password,
                    passwordConfirmation = confirm,
                    contactNo = contactNo,
                    addressBarangay      = barangay,
                    addressMunicipality  = municipal,
                    addressProvince      = province,
                )
            )
        }

        binding.tvLogin.setOnClickListener {
            findNavController().navigateUp()
        }

        viewModel.registerState.observe(viewLifecycleOwner) { result ->
            when (result) {
                is Result.Loading -> {
                    binding.btnRegister.isEnabled = false
                    binding.progressBar.visibility = View.VISIBLE
                }
                is Result.Success -> {
                    binding.progressBar.visibility = View.GONE
                    findNavController().navigate(R.id.action_registerFragment_to_dashboardFragment)
                }
                is Result.Error -> {
                    binding.btnRegister.isEnabled = true
                    binding.progressBar.visibility = View.GONE
                    Toast.makeText(requireContext(), result.message, Toast.LENGTH_LONG).show()
                }
            }
        }
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}
